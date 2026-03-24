<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupWebhookController extends Controller
{
    /**
     * POST /webhook/backup
     * Trigger a backup and return a one-time signed download link.
     */
    public function trigger(Request $request): JsonResponse
    {
        $secret = config('app.backup_secret');

        if (! $secret || ! hash_equals($secret, (string) $request->header('X-Backup-Secret', ''))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $onlyDb = $request->boolean('only_db');
        $onlyFiles = $request->boolean('only_files');
        $callbackUrl = $request->input('callback_url') ?? null;

        // Validate callback_url if provided
        if ($callbackUrl && ! filter_var($callbackUrl, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid callback_url'], 422);
        }

        $args = [];
        if ($onlyDb) {
            $args['--only-db'] = true;
        } elseif ($onlyFiles) {
            $args['--only-files'] = true;
        }

        // DB-only is fast (~1 sec) — run synchronously, then fire callback if requested
        if ($onlyDb) {
            Artisan::call('backup:website', array_filter([
                '--only-db' => true,
                '--callback-url' => $callbackUrl,
            ]));

            return $this->latestBackupResponse();
        }

        // Full / files-only backup is slow — run in background to avoid 504 timeout
        $this->runBackupAsync($args, $callbackUrl);

        return response()->json([
            'status' => 'started',
            'message' => 'Full backup is running in the background.',
            'callback_url' => $callbackUrl ?? null,
            'tip' => $callbackUrl
                ? 'You will receive a POST to your callback_url when the backup is ready.'
                : 'No callback_url provided. Use GET /webhook/backup/latest to check when done.',
        ], 202);
    }

    /**
     * GET /webhook/backup/latest
     * Check if a backup is ready and return its download link.
     * Use this after triggering a full async backup.
     */
    public function latest(Request $request): JsonResponse
    {
        $secret = config('app.backup_secret');

        if (! $secret || ! hash_equals($secret, (string) $request->header('X-Backup-Secret', ''))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $backupDir = storage_path('app/backups');
        $zips = glob("{$backupDir}/*.zip");

        if (! $zips) {
            return response()->json(['status' => 'not_ready', 'message' => 'No backup found yet. Try again in a few minutes.'], 404);
        }

        usort($zips, fn ($a, $b) => filemtime($b) - filemtime($a));
        $latestZip = $zips[0];
        $filename = basename($latestZip);
        $sizeMb = round(filesize($latestZip) / 1024 / 1024, 2);
        $createdAt = date('Y-m-d H:i:s', filemtime($latestZip));

        $downloadUrl = URL::signedRoute('backup.download', ['file' => $filename], now()->addHour());

        return response()->json([
            'status' => 'ready',
            'file' => $filename,
            'size_mb' => $sizeMb,
            'created_at' => $createdAt,
            'download_url' => $downloadUrl,
            'expires_in' => '1 hour',
        ]);
    }

    /**
     * GET /webhook/backup/download/{file}?signature=...
     * Stream the zip file and delete it after download.
     */
    public function download(Request $request, string $file): BinaryFileResponse
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        // prevent path traversal
        $file = basename($file);
        $zipPath = storage_path("app/backups/{$file}");

        if (! file_exists($zipPath)) {
            abort(404, 'Backup file not found.');
        }

        return response()->file($zipPath, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => "attachment; filename=\"{$file}\"",
        ])->deleteFileAfterSend(true);
    }

    /**
     * Find the most recently created backup zip and return a signed download response.
     */
    private function latestBackupResponse(): JsonResponse
    {
        $backupDir = storage_path('app/backups');
        $zips = glob("{$backupDir}/*.zip");

        if (! $zips) {
            return response()->json(['error' => 'Backup failed — no zip found'], 500);
        }

        usort($zips, fn ($a, $b) => filemtime($b) - filemtime($a));
        $latestZip = $zips[0];
        $filename = basename($latestZip);
        $sizeMb = round(filesize($latestZip) / 1024 / 1024, 2);

        $downloadUrl = URL::signedRoute('backup.download', ['file' => $filename], now()->addHour());

        return response()->json([
            'status' => 'ok',
            'file' => $filename,
            'size_mb' => $sizeMb,
            'download_url' => $downloadUrl,
            'expires_in' => '1 hour',
        ]);
    }

    /**
     * Spawn the backup artisan command as a background process (non-blocking).
     *
     * @param  array<string, true>  $args
     */
    private function runBackupAsync(array $args, ?string $callbackUrl = null): void
    {
        $phpBin = PHP_BINARY;

        if (PHP_OS_FAMILY === 'Windows') {
            // In web/CGI context PHP_BINARY points to php-cgi.exe; swap for php.exe (CLI).
            if (strtolower(basename($phpBin)) === 'php-cgi.exe') {
                $phpCliPath = dirname($phpBin).DIRECTORY_SEPARATOR.'php.exe';
                if (file_exists($phpCliPath)) {
                    $phpBin = $phpCliPath;
                }
            }
        } else {
            // On Linux web context PHP_BINARY may point to php-fpm or php-cgi.
            // Find the real CLI binary (php8.2, php8.1, php, etc.).
            $phpBin = $this->findPhpCli();
        }

        $artisan = base_path('artisan');
        $log = storage_path('logs/backup.log');

        $cmdArgs = isset($args['--only-files']) ? ' --only-files' : '';
        if ($callbackUrl) {
            $cmdArgs .= ' --callback-url='.escapeshellarg($callbackUrl);
        }

        if (PHP_OS_FAMILY === 'Windows') {
            // Use PowerShell Start-Process which creates a truly independent process
            // unaffected by PHP-CGI's job object constraints.
            $argParts = [$artisan, 'backup:website'];
            if (isset($args['--only-files'])) {
                $argParts[] = '--only-files';
            }
            if ($callbackUrl) {
                $argParts[] = '--callback-url='.$callbackUrl;
            }
            $phpBinPs = str_replace("'", "''", $phpBin);
            $psArgList = "@('".implode("', '", array_map(fn ($a) => str_replace("'", "''", $a), $argParts))."')";
            $psCmd = "Start-Process -FilePath '{$phpBinPs}' -ArgumentList {$psArgList} -WindowStyle Hidden";
            exec('powershell -NoProfile -NonInteractive -Command "'.$psCmd.'"');
        } else {
            exec(escapeshellarg($phpBin).' '.escapeshellarg($artisan)." backup:website{$cmdArgs} >> ".escapeshellarg($log).' 2>&1 &');
        }
    }

    private function findPhpCli(): string
    {
        // Try versioned binaries first (most specific wins)
        $candidates = [
            '/usr/bin/php8.2',
            '/usr/bin/php8.1',
            '/usr/bin/php8.0',
            '/usr/local/bin/php8.2',
            '/usr/local/bin/php',
            '/usr/bin/php',
        ];

        foreach ($candidates as $path) {
            if (file_exists($path) && is_executable($path)) {
                return $path;
            }
        }

        // Last resort: hope 'php' is in PATH and is a CLI binary
        return 'php';
    }
}