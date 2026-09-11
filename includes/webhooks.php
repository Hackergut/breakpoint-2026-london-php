<?php
declare(strict_types=1);

function pick_field(?array $obj, string ...$keys): string
{
    if (!$obj) {
        return '';
    }
    foreach ($keys as $key) {
        if (!array_key_exists($key, $obj)) {
            continue;
        }
        $value = $obj[$key];
        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }
        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }
    }
    return '';
}

function as_record(mixed $value): ?array
{
    return is_array($value) && array_is_list($value) === false ? $value : (is_array($value) ? $value : null);
}

function lead_from_unknown(mixed $body, string $fallbackId): ?array
{
    $root = as_record($body);
    if (!$root) {
        return null;
    }
    $data = as_record($root['data'] ?? null) ?? $root;
    $sender = as_record($data['sender'] ?? null) ?? as_record($root['sender'] ?? null) ?? $data;

    $first = pick_field($sender, 'fullName', 'name', 'firstName');
    $last = pick_field($sender, 'lastName');
    $name = trim($first . ' ' . $last) ?: pick_field($data, 'name', 'fullName');
    $email = pick_field($sender, 'email') ?: pick_field($data, 'email');
    if ($name === '' && $email === '') {
        return null;
    }

    return [
        'id' => pick_field($root, 'id', 'hashId') ?: (pick_field($data, 'id') ?: $fallbackId),
        'name' => $name,
        'email' => $email,
        'phone' => pick_field($sender, 'phone') ?: pick_field($data, 'phone'),
        'from' => pick_field($sender, 'city', 'country') ?: pick_field($data, 'city', 'from', 'country'),
        'tenure' => pick_field($data, 'tenure'),
        'holdings' => pick_field($data, 'holdings'),
        'wallet' => pick_field($data, 'wallet'),
        'source' => pick_field($root, 'formName', 'event') ?: 'webhook',
        'createdAt' => gmdate('c'),
    ];
}

function verify_forminit_signature(string $rawBody, array $config): ?string
{
    $secret = (string) ($config['forminit_webhook_secret'] ?? '');
    $webhookId = header_value('Forminit-Webhook-Id');
    $timestamp = header_value('Forminit-Webhook-Timestamp');
    $signature = header_value('Forminit-Webhook-Signature');

    if ($secret === '') {
        return $webhookId !== '' ? $webhookId : 'unsigned';
    }
    if (!preg_match('/^wh_[A-Za-z0-9_-]+$/', $webhookId)) {
        return null;
    }
    if (!preg_match('/^\d+$/', $timestamp)) {
        return null;
    }
    if (!preg_match('/^v1=([a-f0-9]{64})$/', $signature, $m)) {
        return null;
    }
    $age = abs(time() - (int) $timestamp);
    if ($age > 300) {
        return null;
    }
    $expected = hash_hmac('sha256', 'v1.' . $webhookId . '.' . $timestamp . '.' . $rawBody, $secret);
    if (!timing_equal($expected, $m[1])) {
        return null;
    }
    return $webhookId;
}

function ingest_lead_webhook(string $rawBody, array $config, string $kind): array
{
    static $seen = [];

    $remember = static function (string $id) use (&$seen): bool {
        $now = time();
        foreach ($seen as $key => $at) {
            if ($now - $at > 15 * 60) {
                unset($seen[$key]);
            }
        }
        if (isset($seen[$id])) {
            return false;
        }
        $seen[$id] = $now;
        return true;
    };

    if ($kind === 'leads') {
        $shared = (string) ($config['webhook_secret'] ?? '');
        if ($shared !== '') {
            $got = header_value('X-Webhook-Secret');
            if ($got === '') {
                $auth = header_value('Authorization');
                $got = preg_replace('/^Bearer\s+/i', '', $auth) ?? '';
            }
            if (!timing_equal($got, $shared)) {
                return ['status' => 401, 'body' => ['ok' => false, 'error' => 'unauthorized']];
            }
        }
    }

    if ($kind === 'forminit') {
        $id = verify_forminit_signature($rawBody, $config);
        if (!$id) {
            return ['status' => 401, 'body' => ['ok' => false, 'error' => 'invalid signature']];
        }
        if (!$remember('fi:' . $id)) {
            return ['status' => 200, 'body' => ['ok' => true, 'duplicate' => true]];
        }
    }

    $parsed = json_decode($rawBody, true);
    if (!is_array($parsed)) {
        return ['status' => 400, 'body' => ['ok' => false, 'error' => 'invalid json']];
    }

    $lead = lead_from_unknown($parsed, 'LW-HOOK');
    if (!$lead) {
        return ['status' => 422, 'body' => ['ok' => false, 'error' => 'missing name/email']];
    }
    if (!$remember('lead:' . $lead['id'] . ':' . $lead['email'])) {
        return ['status' => 200, 'body' => ['ok' => true, 'duplicate' => true]];
    }

    try {
        save_lead($config['leads_file'], $lead);
    } catch (Throwable $e) {
        error_log('[leads] save failed ' . $e->getMessage());
    }
    $ok = deliver_lead_to_telegram($config, $lead);
    return ['status' => 200, 'body' => ['ok' => true, 'telegram' => $ok, 'id' => $lead['id']]];
}
