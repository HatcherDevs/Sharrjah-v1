<?php

/**
 * Backup Client
 *
 * Place this file on the remote server.
 *
 * CLI:   php backup-client.php [--only-db] [--only-files]
 * HTTP:  https://remote-server.com/backup-client.php?token=ACCESS_TOKEN
 *        (optional: &only_db=1  or  &only_files=1)
 */

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// CONFIG â€” edit these values
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

/** Secret token to protect HTTP access â€” add ?token=... to the URL */
const ACCESS_TOKEN = 'BkT9mXpL2wQzRnV5hJeYcA3sDfUoG7Ki';

/** URL of the main server's backup webhook (POST trigger) */
const WEBHOOK_URL = 'https://sharjaharchitecture-591518.hostingersite.com/webhook/backup';

/** URL to poll for backup completion status (GET) */
const STATUS_URL = 'https://sharjaharchitecture-591518.hostingersite.com/site/sync/status';

/** Must match BACKUP_SECRET in the main server's .env */
const BACKUP_SECRET = 'vTOrzBORtlq2YCR113FuHELIqCJQMm3HABMdPo3acMI';

/** Directory to save the downloaded backup zip */
const DOWNLOAD_DIR = __DIR__.'/backups';

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// ROUTING
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

$isCli = PHP_SAPI === 'cli';

if (! $isCli) {
    // Allow callback POSTs from main server without a token
    $isCallbackPost = $_SERVER['REQUEST_METHOD'] === 'POST';

    if (! $isCallbackPost) {
        $token = $_GET['token'] ?? $_SERVER['HTTP_X_ACCESS_TOKEN'] ?? '';
        if (! hash_equals(ACCESS_TOKEN, $token)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }
    }
}

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// CALLBACK â€” main server POSTs the download link here when backup is ready
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

if (! $isCli && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);

    if (! isset($data['status']) || $data['status'] !== 'backup_ready') {
        http_response_code(400);
        echo json_encode(['status' => 'unexpected_payload']);
        exit;
    }

    $downloadUrl = $data['download_url'] ?? null;
    $file = $data['file'] ?? 'backup.zip';
    $sizeMb = $data['size_mb'] ?? '?';

    if (! $downloadUrl) {
        logMsg('Callback received but missing download_url');
        http_response_code(422);
        echo json_encode(['status' => 'missing_download_url']);
        exit;
    }

    logMsg("Callback received: {$file} ({$sizeMb} MB). Downloading...");
    downloadAndSave($downloadUrl, $file);
    http_response_code(200);
    echo json_encode(['status' => 'saved', 'file' => $file]);
    exit;
}

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// TRIGGER â€” send backup request to main server
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

$onlyDb = $isCli ? in_array('--only-db', $argv ?? []) : isset($_GET['only_db']);
$onlyFiles = $isCli ? in_array('--only-files', $argv ?? []) : isset($_GET['only_files']);

// For HTTP full backups, send this file's URL as callback so the main server can POST back
$callbackUrl = null;
if (! $isCli && ! $onlyDb) {
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $path = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    $callbackUrl = $host ? "{$scheme}://{$host}{$path}" : null;
}

$payload = [];
if ($onlyDb) {
    $payload['only_db'] = true;
} elseif ($onlyFiles) {
    $payload['only_files'] = true;
}
if ($callbackUrl) {
    $payload['callback_url'] = $callbackUrl;
}

$type = $onlyDb ? 'DB only' : ($onlyFiles ? 'files only' : 'full');
logMsg("Triggering {$type} backup on main server...");

$response = postJson(WEBHOOK_URL, $payload, BACKUP_SECRET);

if ($response === false) {
    logMsg('ERROR: Could not reach the webhook URL.');
    if (! $isCli) {
        http_response_code(503);
        echo json_encode(['error' => 'webhook_unreachable']);
    }
    exit(1);
}

$httpCode = $response['http_code'];
$data = $response['data'];

logMsg('Response HTTP '.$httpCode.': '.json_encode($data, JSON_UNESCAPED_SLASHES));

// DB-only returns a download link immediately (synchronous on main server)
if ($httpCode === 200 && isset($data['download_url'])) {
    $file = $data['file'] ?? 'backup.zip';
    $sizeMb = $data['size_mb'] ?? '?';
    logMsg("Backup ready ({$sizeMb} MB). Downloading...");
    downloadAndSave($data['download_url'], $file);
    exit(0);
}

// Full / files-only backup runs async on main server
if ($httpCode === 202) {
    if ($isCli) {
        // CLI: poll /webhook/backup/latest until the backup appears, then download
        logMsg('Backup running in background. Polling for completion (max 15 min)...');
        pollAndDownload();
    } else {
        // HTTP: callback will POST back to this file when backup is ready
        logMsg('Backup started. Will download automatically via callback when ready.');
        logMsg('Check '.__DIR__.'/backups/backup-client.log for progress.');
        http_response_code(202);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'started',
            'message' => 'Backup is running on main server. Will save here automatically when done.',
            'log_hint' => 'Check /backups/backup-client.log for updates.',
        ]);
    }
}

exit(0);

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// HELPERS
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

function downloadAndSave(string $url, string $file): void
{
    ensureDir(DOWNLOAD_DIR);
    $savePath = DOWNLOAD_DIR.'/'.basename($file);
    logMsg("Downloading to: {$savePath}");

    if (downloadFile($url, $savePath)) {
        $actualMb = round(filesize($savePath) / 1024 / 1024, 2);
        logMsg("Done. Saved: {$savePath} ({$actualMb} MB)");
    } else {
        logMsg("ERROR: Download failed for URL: {$url}");
        if (file_exists($savePath)) {
            unlink($savePath);
        }
    }
}

function pollAndDownload(): void
{
    $maxSeconds = 900; // 15 minutes
    $interval = 20; // check every 20 seconds
    $elapsed = 0;

    while ($elapsed < $maxSeconds) {
        sleep($interval);
        $elapsed += $interval;

        $response = postJson(STATUS_URL, [], BACKUP_SECRET);

        if ($response && isset($response['data']['download_url'])) {
            $d = $response['data'];
            logMsg("Backup ready: {$d['file']} ({$d['size_mb']} MB). Downloading...");
            downloadAndSave($d['download_url'], $d['file']);

            return;
        }

        logMsg("Still waiting... ({$elapsed}s elapsed)");
    }

    logMsg('ERROR: Timed out waiting for backup after '.$maxSeconds.'s');
}

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

/**
 * @return array{http_code: int, data: mixed}|false
 */
function getJson(string $url, string $secret): array|false
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_HTTPGET => true,
        CURLOPT_HTTPHEADER => ['X-Backup-Secret: '.$secret],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
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
        CURLOPT_TIMEOUT => 0,
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

    $logFile = DOWNLOAD_DIR.'/backup-client.log';
    ensureDir(dirname($logFile));
    file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}

/** Must match BACKUP_SECRET in the main server's .env */
const BACKUP_SECRET = 'vTOrzBORtlq2YCR113FuHELIqCJQMm3HABMdPo3acMI';

/**
 * After the full backup finishes, the main server will POST the download link here.
 * Set to the public URL of THIS file on the remote server, e.g.:
 *   'https://remote-server.com/backup-client.php'
 * Set to null to disable the callback (you can poll /webhook/backup/latest instead).
 */
const CALLBACK_URL = 'https://lightskyblue-pheasant-191750.hostingersite.com/backup-client.php';

/** Directory to save the downloaded backup zip */
const DOWNLOAD_DIR = __DIR__.'/backups';

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// ROUTING â€” handle incoming callback POST from main server
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

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
                logMsg("Backup downloaded: {$file} ({$sizeMb} MB) â†’ {$savePath}");
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// TRIGGER â€” send backup request to main server
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

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

// Full backup is async â€” wait for callback, or poll /latest
if ($httpCode === 202) {
    if (CALLBACK_URL) {
        logMsg('Full backup started. Will receive callback at: '.CALLBACK_URL);
    } else {
        logMsg('Full backup started. Poll GET /webhook/backup/latest with X-Backup-Secret to check status.');
    }
}

exit(0);