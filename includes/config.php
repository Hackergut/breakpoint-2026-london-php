<?php
declare(strict_types=1);

return [
    'app_name' => 'Solana London Week — Free Ticket',
    'event_name' => 'Solana London Week 2026',
    'event_start' => '2026-11-15T09:00:00+00:00',
    'telegram_token' => getenv('TELEGRAM_BOT_TOKEN') ?: '',
    'telegram_chat_id' => getenv('TELEGRAM_CHAT_ID') ?: (getenv('TELEGRAM_ADMIN_CHAT_ID') ?: '-5221579158'),
    'telegram_thread_id' => getenv('TELEGRAM_THREAD_ID') ?: '',
    'forminit_webhook_secret' => getenv('FORMINIT_WEBHOOK_SECRET') ?: '',
    'webhook_secret' => getenv('WEBHOOK_SECRET') ?: '',
    'leads_file' => dirname(__DIR__) . '/data/leads.json',
];
