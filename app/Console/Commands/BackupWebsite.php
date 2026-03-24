<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

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
        $archivePath = "{$backupDir}/{$timestamp}.zip";
        $onlyDb = $this->option('only-db');
        $onlyFiles = $this->option('only-files');

        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $this->clearAllBackups($backupDir);

        return $this->handleViaZipArchive($archivePath, $backupDir, $timestamp, $onlyDb, $onlyFiles);
    }

    private function handleViaZipArchive(
        string $archivePath,
        string $backupDir,
        string $timestamp,
        bool $onlyDb,
        bool $onlyFiles
    ): int {
        $zip = new ZipArchive;

        if ($zip->open($archivePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->error("Cannot create zip file: {$archivePath}");

            return self::FAILURE;
        }

        $filesAdded = 0;

        if (! $onlyFiles) {
            $this->info('Dumping database...');
            $sqlPath = $this->dumpDatabase($backupDir, $timestamp);

            if ($sqlPath) {
                $zip->addFile($sqlPath, 'db-dump.sql');
                $this->info('  Database dump added.');
                $filesAdded++;
            } else {
                $this->warn('  Database dump failed — skipping.');
                if ($onlyDb) {
                    $zip->close();
                    if (file_exists($archivePath)) {
                        unlink($archivePath);
                    }
                    $this->error('Nothing to backup. Aborting.');

                    return self::FAILURE;
                }
            }
        }

        if (! $onlyDb) {
            $this->info('Adding public/ directory...');
            $this->addDirToZip($zip, public_path(), 'public');
            $this->info('  public/ added.');
            $filesAdded++;
        }

        $zip->close();

        if (isset($sqlPath) && $sqlPath && file_exists($sqlPath)) {
            unlink($sqlPath);
        }

        if ($filesAdded === 0 || ! file_exists($archivePath)) {
            $this->error('Nothing was added to the backup. Aborting.');

            return self::FAILURE;
        }

        $sizeMb = round(filesize($archivePath) / 1024 / 1024, 2);
        $this->info("Backup completed: {$archivePath} ({$sizeMb} MB)");

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
            $this->warn('  mysqldump not found — trying PDO fallback...');

            return $this->dumpDatabaseViaPdo($dir, $timestamp);
        }

        $passArg = $password ? ' -p'.escapeshellarg($password) : '';

        // Prefer Unix socket when host is localhost — avoids TCP access-denied issues
        $socketFile = config('database.connections.mysql.unix_socket', '/var/run/mysqld/mysqld.sock');
        $useSocket = ($host === 'localhost' || $host === '127.0.0.1') && file_exists($socketFile);

        if ($useSocket) {
            $cmd = sprintf(
                '%s --socket=%s -u %s%s %s > %s 2>&1',
                escapeshellarg($mysqldump),
                escapeshellarg($socketFile),
                escapeshellarg($username),
                $passArg,
                escapeshellarg($database),
                escapeshellarg($sqlPath)
            );
        } else {
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
        }

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            $this->warn('  mysqldump error: '.implode(' ', $output));
            $this->warn('  Trying PDO fallback...');

            return $this->dumpDatabaseViaPdo($dir, $timestamp);
        }

        return $sqlPath;
    }

    /**
     * Fallback database dump using PDO (no mysqldump binary needed).
     */
    private function dumpDatabaseViaPdo(string $dir, string $timestamp): ?string
    {
        try {
            $host = config('database.connections.mysql.host', '127.0.0.1');
            $port = config('database.connections.mysql.port', '3306');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $sqlPath = "{$dir}/db-{$timestamp}.sql";

            $pdo = new \PDO(
                "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
                $username,
                $password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );

            $handle = fopen($sqlPath, 'w');
            fwrite($handle, "-- PDO dump: {$database} @ ".date('Y-m-d H:i:s')."\n");
            fwrite($handle, "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n\n");

            $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // Write CREATE TABLE
                $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
                fwrite($handle, $create['Create Table'].";\n\n");

                // Write INSERT rows in chunks
                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                foreach (array_chunk($rows, 500) as $chunk) {
                    $values = array_map(function (array $row) use ($pdo): string {
                        $escaped = array_map(
                            fn ($v) => $v === null ? 'NULL' : $pdo->quote((string) $v),
                            $row
                        );

                        return '('.implode(',', $escaped).')';
                    }, $chunk);
                    fwrite($handle, "INSERT INTO `{$table}` VALUES\n".implode(",\n", $values).";\n");
                }
                fwrite($handle, "\n");
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
            fclose($handle);

            return $sqlPath;
        } catch (\Throwable $e) {
            $this->warn('  PDO dump failed: '.$e->getMessage());

            return null;
        }
    }

    private function findMysqldump(): ?string
    {
        // Check if mysqldump is directly available
        exec('mysqldump --version 2>&1', $out, $code);
        if ($code === 0) {
            return 'mysqldump';
        }

        // Common paths — prefer mariadb-dump on MariaDB servers, then mysqldump
        $paths = [
            '/usr/bin/mariadb-dump',
            '/usr/local/bin/mariadb-dump',
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

    private function addDirToZip(ZipArchive $zip, string $dir, string $prefix): void
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

            $zip->addFile($realPath, $relativePath);
        }
    }

    private function clearAllBackups(string $dir): void
    {
        $patterns = ['*.zip', '*.tar.gz', '*.tar'];

        foreach ($patterns as $pattern) {
            foreach (glob("{$dir}/{$pattern}") ?: [] as $old) {
                unlink($old);
                $this->info('Cleared old backup: '.basename($old));
            }
        }
    }
}