<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

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
                            {--reason=manual : Reason for blocking}
                            {--permanent : Block IP permanently (adds to code)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage blocked IP addresses (block, unblock, list, clear)';

    /**
     * Path to the middleware file
     */
    protected $middlewarePath;

    public function __construct()
    {
        parent::__construct();
        $this->middlewarePath = config_path('blocked-ips.php');
    }

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

        $reason = $this->option('reason');
        $permanent = $this->option('permanent');

        // حظر دائم - إضافة للكود
        if ($permanent) {
            return $this->addPermanentBlock($ip, $reason);
        }

        // حظر مؤقت - Cache
        $duration = (int) $this->option('duration');

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
            'permanent' => false,
        ];
        Cache::put('blocked_ips_list', $blockedList, now()->addDays(7));

        $this->info("✅ IP {$ip} has been blocked for {$duration} minutes");
        $this->info("   Reason: {$reason}");
        
        return 0;
    }

    /**
     * Add permanent block to config file
     */
    protected function addPermanentBlock(string $ip, string $reason): int
    {
        if (!File::exists($this->middlewarePath)) {
            $this->error('Config file not found: ' . $this->middlewarePath);
            return 1;
        }

        $content = File::get($this->middlewarePath);

        // تحقق إذا IP موجود مسبقاً
        if (str_contains($content, "'{$ip}'")) {
            $this->warn("⚠️  IP {$ip} is already permanently blocked");
            return 0;
        }

        // إيجاد مكان array المحظورة وإضافة IP جديد
        $date = now()->format('Y-m-d');
        $newEntry = "        '{$ip}', // {$reason} - {$date}";

        // البحث عن نهاية array المحظورة
        $pattern = "/('permanently_blocked'\s*=>\s*\[[\s\S]*?)(^\s*\],)/m";
        
        if (preg_match($pattern, $content, $matches)) {
            $replacement = $matches[1] . $newEntry . "\n" . $matches[2];
            $newContent = preg_replace($pattern, $replacement, $content);
            
            File::put($this->middlewarePath, $newContent);

            // حفظ في القائمة أيضاً
            $blockedList = Cache::get('blocked_ips_list', []);
            $blockedList[$ip] = [
                'blocked_at' => now()->toIso8601String(),
                'reason' => $reason,
                'expires_at' => 'NEVER',
                'permanent' => true,
            ];
            Cache::put('blocked_ips_list', $blockedList, now()->addYears(10));

            $this->info("✅ IP {$ip} has been PERMANENTLY blocked");
            $this->info("   Reason: {$reason}");
            $this->info("   Added to: config/blocked-ips.php");
            $this->newLine();
            $this->warn("⚠️  Remember to deploy/commit the changes!");
            
            return 0;
        }

        $this->error('Could not find permanently_blocked array in config file');
        return 1;
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

        // التحقق إذا كان محظور بشكل دائم في الكود
        $permanentIps = $this->getPermanentlyBlockedIps();
        if (isset($permanentIps[$ip])) {
            $this->removePermanentBlock($ip);
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
     * Remove permanent block from config file
     */
    protected function removePermanentBlock(string $ip): bool
    {
        if (!File::exists($this->middlewarePath)) {
            return false;
        }

        $content = File::get($this->middlewarePath);

        // حذف السطر الذي يحتوي على IP
        $pattern = "/\s*['\"]" . preg_quote($ip, '/') . "['\"],?\s*\/\/.*\n/";
        $newContent = preg_replace($pattern, "\n", $content);

        if ($newContent !== $content) {
            File::put($this->middlewarePath, $newContent);
            $this->info("   🔓 Removed from permanent block list (config)");
            $this->warn("   ⚠️  Remember to deploy/commit the changes!");
            return true;
        }

        return false;
    }

    /**
     * List all blocked IPs
     */
    protected function listBlockedIps(): int
    {
        // قراءة IPs المحظورة من الكود
        $permanentIps = $this->getPermanentlyBlockedIps();
        
        // قراءة IPs المحظورة مؤقتاً
        $blockedList = Cache::get('blocked_ips_list', []);

        $this->info("📋 Blocked IPs:");
        $this->newLine();

        // عرض المحظورين دائماً
        if (!empty($permanentIps)) {
            $this->info("🔒 Permanently Blocked (in code):");
            foreach ($permanentIps as $ip => $comment) {
                $this->line("   • {$ip} - {$comment}");
            }
            $this->newLine();
        }

        // عرض المحظورين مؤقتاً
        if (!empty($blockedList)) {
            $headers = ['IP Address', 'Blocked At', 'Expires At', 'Reason', 'Status'];
            $rows = [];

            foreach ($blockedList as $ip => $data) {
                $isPermanent = isset($permanentIps[$ip]);
                $isStillBlocked = Cache::has("blocked_ip:{$ip}") || $isPermanent;
                
                $status = $isPermanent ? '🔒 Permanent' : ($isStillBlocked ? '🔴 Blocked' : '🟢 Expired');
                
                $rows[] = [
                    $ip,
                    $data['blocked_at'] ?? 'N/A',
                    $data['expires_at'] ?? 'N/A',
                    $data['reason'] ?? 'N/A',
                    $status,
                ];
            }

            $this->table($headers, $rows);
        } elseif (empty($permanentIps)) {
            $this->info('No blocked IPs found');
        }
        
        return 0;
    }

    /**
     * Get permanently blocked IPs from middleware file
     */
    protected function getPermanentlyBlockedIps(): array
    {
        if (!File::exists($this->middlewarePath)) {
            return [];
        }

        $content = File::get($this->middlewarePath);
        $ips = [];

        // استخراج IPs من array
        if (preg_match('/\$permanentlyBlockedIps\s*=\s*\[([\s\S]*?)\];/', $content, $matches)) {
            $arrayContent = $matches[1];
            
            // استخراج كل IP مع التعليق
            preg_match_all("/['\"]([^'\"]+)['\"],?\s*\/\/\s*(.+)/", $arrayContent, $ipMatches, PREG_SET_ORDER);
            
            foreach ($ipMatches as $match) {
                $ips[$match[1]] = trim($match[2]);
            }
        }

        return $ips;
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