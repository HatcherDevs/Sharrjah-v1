<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Phar;
use PharData;

class BackupWebsite extends Command
{
    protected $signature = 'backup:website
                            {--only-db : Backup database only}
                            {--only-files : Backup public files only}
                            {--callback-url= : URL to notify when backup is done (receives a POST with download_url)}';

    protected $description = 'Backup the website: database dump + public/ directory';

    public function handle(): int
    {
        $timestamp = now()->format('Y-m-d-H-i-s');
        $backupDir = storage_path('app/backups');
        $tarPath = "{$backupDir}/{$timestamp}.tar";
        $archivePath = "{$tarPath}.gz";
        $onlyDb = $this->option('only-db');
        $onlyFiles = $this->option('only-files');

        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $this->clearAllBackups($backupDir);

        $phar = new PharData($tarPath);

        if (! $onlyFiles) {
            $this->info('Dumping database...');
            $sqlPath = $this->dumpDatabase($backupDir, $timestamp);

            if ($sqlPath) {
                $phar->addFile($sqlPath, 'db-dump.sql');
                $this->info('  Database dump added.');
            } else {
                $this->warn('  Database dump failed — skipping.');
            }
        }

        if (! $onlyDb) {
            $this->info('Adding public/ directory...');
            $publicPath = public_path();
            $this->addDirToTar($phar, $publicPath, 'public');
            $this->info('  public/ added.');
        }

        $phar->compress(Phar::GZ);
        unset($phar);

        // remove the uncompressed .tar
        if (file_exists($tarPath)) {
            unlink($tarPath);
        }

        // remove temp sql file
        if (isset($sqlPath) && $sqlPath && file_exists($sqlPath)) {
            unlink($sqlPath);
        }

        $sizeMb = round(filesize($archivePath) / 1024 / 1024, 2);
        $this->info("Backup completed: {$archivePath} ({$sizeMb} MB)");

        // Notify callback URL if provided
        $callbackUrl = $this->option('callback-url');
        if ($callbackUrl) {
            $this->sendCallback($callbackUrl, $archivePath);
        }

        return self::SUCCESS;
    }

    /**
     * Send a POST callback with the download link once backup is complete.
     */
    private function sendCallback(string $callbackUrl, string $zipPath): void
    {
        try {
            $filename = basename($zipPath);
            $sizeMb = round(filesize($zipPath) / 1024 / 1024, 2);
            $downloadUrl = \Illuminate\Support\Facades\URL::signedRoute(
                'backup.download',
                ['file' => $filename],
                now()->addHours(24)
            );

            $payload = json_encode([
                'status' => 'backup_ready',
                'file' => $filename,
                'size_mb' => $sizeMb,
                'download_url' => $downloadUrl,
                'expires_in' => '24 hours',
            ]);

            $ch = curl_init($callbackUrl);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: '.strlen($payload)],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $this->info("Callback sent to {$callbackUrl} — HTTP {$httpCode}");
        } catch (\Throwable $e) {
            $this->warn('Callback failed: '.$e->getMessage());
        }
    }

    private function dumpDatabase(string $dir, string $timestamp): ?string
    {
        $host = config('database.connections.mysql.host', '127.0.0.1');
        $port = config('database.connections.mysql.port', '3306');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $sqlPath = "{$dir}/db-{$timestamp}.sql";

        $mysqldump = $this->findMysqldump();

        if (! $mysqldump) {
            $this->warn('  mysqldump not found in PATH or common locations.');

            return null;
        }

        $passArg = $password ? ' -p'.escapeshellarg($password) : '';
        $cmd = sprintf(
            '%s -h %s -P %s -u %s%s %s > %s 2>&1',
            escapeshellarg($mysqldump),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $passArg,
            escapeshellarg($database),
            escapeshellarg($sqlPath)
        );

        exec($cmd, $output, $exitCode);

        return $exitCode === 0 ? $sqlPath : null;
    }

    private function findMysqldump(): ?string
    {
        // Check if mysqldump is directly available
        exec('mysqldump --version 2>&1', $out, $code);
        if ($code === 0) {
            return 'mysqldump';
        }

        // Common paths on Linux/Hostinger servers
        $paths = [
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            '/usr/local/mysql/bin/mysqldump',
            '/opt/plesk/mysql/bin/mysqldump',
        ];

        foreach ($paths as $path) {
            if (file_exists($path) && is_executable($path)) {
                return $path;
            }
        }

        return null;
    }

    private function addDirToTar(PharData $phar, string $dir, string $prefix): void
    {
        $skip = [
            realpath(public_path('admin')),
            realpath(public_path('froala_editor')),
        ];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $realPath = $file->getRealPath();

            foreach ($skip as $skipPath) {
                if ($skipPath && str_starts_with($realPath, $skipPath)) {
                    continue 2;
                }
            }

            $relativePath = $prefix.'/'.str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                substr($realPath, strlen($dir) + 1)
            );

            $phar->addFile($realPath, $relativePath);
        }
    }

    private function clearAllBackups(string $dir): void
    {
        $patterns = ['*.tar.gz', '*.tar', '*.zip'];

        foreach ($patterns as $pattern) {
            foreach (glob("{$dir}/{$pattern}") ?: [] as $old) {
                unlink($old);
                $this->info('Cleared old backup: '.basename($old));
            }
        }
    }
}