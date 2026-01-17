<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ManageBlockedIps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ip:manage 
                            {action : Action to perform (block|unblock|list|clear)}
                            {ip? : IP address to block/unblock}
                            {--duration=60 : Duration in minutes for temporary block}
                            {--reason=manual : Reason for blocking}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage blocked IP addresses (block, unblock, list, clear)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $ip = $this->argument('ip');

        switch ($action) {
            case 'block':
                return $this->blockIp($ip);
            case 'unblock':
                return $this->unblockIp($ip);
            case 'list':
                return $this->listBlockedIps();
            case 'clear':
                return $this->clearAllBlocks();
            default:
                $this->error("Unknown action: {$action}");
                $this->info("Available actions: block, unblock, list, clear");
                return 1;
        }
    }

    /**
     * Block an IP address
     */
    protected function blockIp(?string $ip): int
    {
        if (empty($ip)) {
            $this->error('Please provide an IP address to block');
            return 1;
        }

        $duration = (int) $this->option('duration');
        $reason = $this->option('reason');

        Cache::put(
            "blocked_ip:{$ip}",
            [
                'blocked_at' => now()->toIso8601String(),
                'reason' => $reason,
                'duration' => $duration,
            ],
            now()->addMinutes($duration)
        );

        // حفظ في قائمة IPs المحظورة للعرض لاحقاً
        $blockedList = Cache::get('blocked_ips_list', []);
        $blockedList[$ip] = [
            'blocked_at' => now()->toIso8601String(),
            'reason' => $reason,
            'expires_at' => now()->addMinutes($duration)->toIso8601String(),
        ];
        Cache::put('blocked_ips_list', $blockedList, now()->addDays(7));

        $this->info("✅ IP {$ip} has been blocked for {$duration} minutes");
        $this->info("   Reason: {$reason}");
        
        return 0;
    }

    /**
     * Unblock an IP address
     */
    protected function unblockIp(?string $ip): int
    {
        if (empty($ip)) {
            $this->error('Please provide an IP address to unblock');
            return 1;
        }

        Cache::forget("blocked_ip:{$ip}");
        Cache::forget("csrf_errors:{$ip}");

        // إزالة من القائمة
        $blockedList = Cache::get('blocked_ips_list', []);
        unset($blockedList[$ip]);
        Cache::put('blocked_ips_list', $blockedList, now()->addDays(7));

        $this->info("✅ IP {$ip} has been unblocked");
        
        return 0;
    }

    /**
     * List all blocked IPs
     */
    protected function listBlockedIps(): int
    {
        $blockedList = Cache::get('blocked_ips_list', []);

        if (empty($blockedList)) {
            $this->info('No blocked IPs found');
            return 0;
        }

        $this->info("📋 Blocked IPs:");
        $this->newLine();

        $headers = ['IP Address', 'Blocked At', 'Expires At', 'Reason', 'Status'];
        $rows = [];

        foreach ($blockedList as $ip => $data) {
            $isStillBlocked = Cache::has("blocked_ip:{$ip}");
            $rows[] = [
                $ip,
                $data['blocked_at'] ?? 'N/A',
                $data['expires_at'] ?? 'N/A',
                $data['reason'] ?? 'N/A',
                $isStillBlocked ? '🔴 Blocked' : '🟢 Expired',
            ];
        }

        $this->table($headers, $rows);
        
        return 0;
    }

    /**
     * Clear all temporary blocks
     */
    protected function clearAllBlocks(): int
    {
        if (!$this->confirm('Are you sure you want to clear all temporary blocks?')) {
            $this->info('Operation cancelled');
            return 0;
        }

        $blockedList = Cache::get('blocked_ips_list', []);
        
        foreach (array_keys($blockedList) as $ip) {
            Cache::forget("blocked_ip:{$ip}");
            Cache::forget("csrf_errors:{$ip}");
        }

        Cache::forget('blocked_ips_list');

        $this->info("✅ All temporary blocks have been cleared");
        
        return 0;
    }
}