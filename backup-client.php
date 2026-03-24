<?php

/**
 * Backup Client
 *
 * Place this file on the remote server.
 * Call it via CLI (cron) or via HTTP.
 *
 * CLI:   php backup-client.php [--only-db] [--only-files]
 * HTTP:  https://remote-server.com/backup-client.php
 *        (optional query: ?only_db=1  or  ?only_files=1)
 */

// ─────────────────────────────────────────────────────────────────────────────
// CONFIG — edit these values
// ─────────────────────────────────────────────────────────────────────────────

/** URL of the main server's backup webhook */
const WEBHOOK_URL = 'https://satv1.test/webhook/backup';

/** Must match BACKUP_SECRET in the main server's .env */
const BACKUP_SECRET = 'vTOrzBORtlq2YCR113FuHELIqCJQMm3HABMdPo3acMI';

/**
 * After the full backup finishes, the main server will POST the download link here.
 * Set to the public URL of THIS file on the remote server, e.g.:
 *   'https://remote-server.com/backup-client.php'
 * Set to null to disable the callback (you can poll /webhook/backup/latest instead).
 */
const CALLBACK_URL = null; // e.g. 'https://remote-server.com/backup-client.php'

/** Directory to save the downloaded backup zip */
const DOWNLOAD_DIR = __DIR__.'/backups';

// ─────────────────────────────────────────────────────────────────────────────
// ROUTING — handle incoming callback POST from main server
// ─────────────────────────────────────────────────────────────────────────────

$isCli = PHP_SAPI === 'cli';

// When the main server calls back with the download link
if (! $isCli && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);

    if (isset($data['status']) && $data['status'] === 'backup_ready') {
        $downloadUrl = $data['download_url'] ?? null;
        $file = $data['file'] ?? 'backup.zip';
        $sizeMb = $data['size_mb'] ?? '?';

        if ($downloadUrl) {
            ensureDir(DOWNLOAD_DIR);
            $savePath = DOWNLOAD_DIR.'/'.$file;

            $success = downloadFile($downloadUrl, $savePath);

            if ($success) {
                logMsg("Backup downloaded: {$file} ({$sizeMb} MB) → {$savePath}");
                http_response_code(200);
                echo json_encode(['status' => 'saved', 'file' => $savePath]);
            } else {
                logMsg("Download FAILED for: {$downloadUrl}");
                http_response_code(500);
                echo json_encode(['status' => 'download_failed']);
            }
        } else {
            http_response_code(422);
            echo json_encode(['status' => 'missing_download_url']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'unexpected_payload']);
    }

    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// TRIGGER — send backup request to main server
// ─────────────────────────────────────────────────────────────────────────────

$onlyDb = $isCli ? in_array('--only-db', $argv ?? []) : isset($_GET['only_db']);
$onlyFiles = $isCli ? in_array('--only-files', $argv ?? []) : isset($_GET['only_files']);

$payload = [];
if ($onlyDb) {
    $payload['only_db'] = true;
} elseif ($onlyFiles) {
    $payload['only_files'] = true;
}
if (CALLBACK_URL) {
    $payload['callback_url'] = CALLBACK_URL;
}

logMsg('Triggering backup on main server'.($onlyDb ? ' (DB only)' : ($onlyFiles ? ' (files only)' : ' (full)')).' ...');

$response = postJson(WEBHOOK_URL, $payload, BACKUP_SECRET);

if ($response === false) {
    logMsg('ERROR: Could not reach the webhook URL.');
    exit(1);
}

$httpCode = $response['http_code'];
$data = $response['data'];

logMsg("Response HTTP {$httpCode}: ".json_encode($data, JSON_UNESCAPED_SLASHES));

// DB-only returns a download_url immediately
if ($httpCode === 200 && isset($data['download_url'])) {
    $downloadUrl = $data['download_url'];
    $file = $data['file'] ?? 'backup.zip';
    $sizeMb = $data['size_mb'] ?? '?';

    logMsg("Backup ready ({$sizeMb} MB). Downloading...");
    ensureDir(DOWNLOAD_DIR);
    $savePath = DOWNLOAD_DIR.'/'.$file;

    if (downloadFile($downloadUrl, $savePath)) {
        logMsg("Saved to: {$savePath}");
    } else {
        logMsg('ERROR: Download failed.');
        exit(1);
    }
}

// Full backup is async — wait for callback, or poll /latest
if ($httpCode === 202) {
    if (CALLBACK_URL) {
        logMsg('Full backup started. Will receive callback at: '.CALLBACK_URL);
    } else {
        logMsg('Full backup started. Poll GET /webhook/backup/latest with X-Backup-Secret to check status.');
    }
}

exit(0);

// ─────────────────────────────────────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────────────────────────────────────

/**
 * @param  array<string, mixed>  $payload
 * @return array{http_code: int, data: mixed}|false
 */
function postJson(string $url, array $payload, string $secret): array|false
{
    $json = json_encode($payload);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Content-Length: '.strlen($json),
            'X-Backup-Secret: '.$secret,
            'User-Agent: BackupClient/1.0',
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $body = curl_exec($ch);

    if ($body === false) {
        return false;
    }

    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['http_code' => $httpCode, 'data' => json_decode($body, true)];
}

function downloadFile(string $url, string $savePath): bool
{
    $fp = fopen($savePath, 'wb');

    if (! $fp) {
        return false;
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 0, // no timeout — large files
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);

    if ($httpCode !== 200) {
        @unlink($savePath);

        return false;
    }

    return true;
}

function ensureDir(string $dir): void
{
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

function logMsg(string $msg): void
{
    $line = '['.date('Y-m-d H:i:s').'] '.$msg.PHP_EOL;
    echo $line;

    $logFile = __DIR__.'/backups/backup-client.log';
    ensureDir(dirname($logFile));
    file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}
