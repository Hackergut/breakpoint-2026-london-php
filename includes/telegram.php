<?php
declare(strict_types=1);

function deliver_lead_to_telegram(array $config, array $lead): bool
{
    $token = trim((string) ($config['telegram_token'] ?? ''));
    $chatId = trim((string) ($config['telegram_chat_id'] ?? ''));
    $threadId = trim((string) ($config['telegram_thread_id'] ?? ''));

    if ($token === '' || $chatId === '') {
        error_log('[leads] Telegram not configured — set TELEGRAM_BOT_TOKEN and TELEGRAM_CHAT_ID');
        return false;
    }

    $esc = static function (string $s): string {
        return str_replace(
            ['&', '<', '>'],
            ['&', '<', '>'],
            $s,
        );
    };

    $lines = [
        '<b>BP26 LEAD</b>  <code>' . $esc(clean_text($lead['id'] ?? '')) . '</code>',
        '',
        '<b>Name</b>  ' . $esc(clean_text($lead['name'] ?? '')),
        '<b>Email</b>  ' . $esc(clean_text($lead['email'] ?? '')),
        '<b>Phone</b>  ' . $esc(clean_text($lead['phone'] ?? '')),
        '<b>From</b>  ' . $esc(clean_text($lead['from'] ?? '')),
        '<b>In crypto</b>  ' . $esc(clean_text($lead['tenure'] ?? '')),
        '<b>Holdings</b>  ' . $esc(clean_text($lead['holdings'] ?? '')),
        '<b>Wallet</b>  ' . $esc(clean_text($lead['wallet'] ?? '')),
    ];
    if (!empty($lead['source'])) {
        $lines[] = '<b>Source</b>  ' . $esc(clean_text((string) $lead['source']));
    }
    $text = implode("\n", $lines);

    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML',
        'disable_web_page_preview' => true,
    ];
    if ($threadId !== '') {
        $payload['message_thread_id'] = (int) $threadId;
    }

    $url = 'https://api.telegram.org/bot' . rawurlencode($token) . '/sendMessage';
    $json = json_encode($payload, JSON_UNESCAPED_UNICODE);

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 12,
        ]);
        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status < 200 || $status >= 300) {
            error_log('[leads] Telegram send failed ' . $status . ' ' . substr((string) $body, 0, 300));
            return false;
        }
        return true;
    }

    $ctx = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $json,
            'timeout' => 12,
            'ignore_errors' => true,
        ],
    ]);
    $body = @file_get_contents($url, false, $ctx);
    $statusLine = $http_response_header[0] ?? '';
    if (!preg_match('/\s2\d\d\s/', $statusLine)) {
        error_log('[leads] Telegram send failed ' . $statusLine . ' ' . substr((string) $body, 0, 300));
        return false;
    }
    return true;
}
