<?php

/**
 * قائمة IPs المحظورة بشكل دائم - EXAMPLE/TEMPLATE
 * انسخ هذا الملف إلى blocked-ips.php وعدّل القيم حسب احتياجاتك
 * يدعم IPv4 و IPv6 و CIDR ranges
 */

return [
    'permanently_blocked' => [
        '69.58.12.239', // DoS attacker - 2026-01-17
        '1.2.3.4', // DoS attack - 2026-01-17
        '206.189.2.13', // DoS attack - 2026-01-17
        '64.226.65.160', // DoS attack - 2026-01-17
        '66.249.64.132', // DoS attack - 2026-01-18
        '66.249.64.96', // DoS attack - 2026-01-18
        '93.127.142.98', // DoS attack - 2026-01-18
        '185.194.178.49', // DoS attack - 2026-01-18
        '66.249.89.160', // DoS attack - 2026-01-18
        '185.194.178.55', // DoS attack - 2026-01-18
        '185.194.178.93', // DoS attack - 2026-01-18
        '43.135.139.165', // DoS attack - 2026-01-18
        '43.164.195.17', // DoS attack - 2026-01-18
        '186.122.11.167', // DoS attack - 2026-01-18
        '172.93.218.16', // DoS attack - 2026-01-18
        '45.154.138.42', // DoS attack - 2026-01-18
        '220.181.51.116', // DoS attack - 2026-01-18
        '220.181.51.88', // DoS attack - 2026-01-18
        '168.194.26.26', // DoS attack - 2026-01-18
        '45.154.138.39', // DoS attack - 2026-01-18
        '191.6.52.229', // DoS attack - 2026-01-18
        '2600:1900:4180:348:0:23a::', // DoS attack IPv6 - 2026-01-18
        '14.231.153.74', // DoS attack - 2026-01-18
    ],

    'whitelisted' => [
        '127.0.0.1',           // localhost
        '::1',                 // IPv6 localhost
        // أضف IPs موثوقة هنا
    ],

    /**
     * إعدادات Rate Limiting
     */
    'rate_limit' => [
        'max_requests_per_minute' => 60,
        'max_requests_per_10_seconds' => 15,
        'auto_ban_duration_minutes' => 30,
    ],

    /**
     * إعدادات CSRF
     */
    'csrf' => [
        'max_errors_before_ban' => 5,
    ],
];