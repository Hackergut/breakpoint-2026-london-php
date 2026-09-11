<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function clean_text(mixed $value, int $max = 400): string
{
    $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', (string) ($value ?? '')) ?? '';
    $s = trim($s);
    if (function_exists('mb_substr')) {
        return mb_substr($s, 0, $max);
    }
    return substr($s, 0, $max);
}

function ticket_id(): string
{
    return 'LW-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
}

function encrypt_span(
    string $text,
    string $charset = '≠#∞?^%÷±∆*@/&|∑[]{}~!62≈',
    string $encClass = 'text-primary',
    string $revClass = 'text-fg',
    int $delay = 70,
    string $class = '',
): string {
    $cls = trim('bp-encrypted ' . $class);
    return sprintf(
        '<span class="%s" data-encrypt="%s" data-charset="%s" data-enc-class="%s" data-rev-class="%s" data-delay="%d" aria-label="%s">%s</span>',
        e($cls),
        e($text),
        e($charset),
        e($encClass),
        e($revClass),
        $delay,
        e($text),
        e($text),
    );
}

function load_leads(string $file): array
{
    if (!is_file($file)) {
        return [];
    }
    $raw = file_get_contents($file);
    if ($raw === false || $raw === '') {
        return [];
    }
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function save_lead(string $file, array $lead): void
{
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0750, true);
    }
    $leads = load_leads($file);
    $leads[] = $lead;
    $fp = fopen($file, 'c+');
    if ($fp === false) {
        throw new RuntimeException('Cannot write leads file');
    }
    try {
        flock($fp, LOCK_EX);
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        fflush($fp);
    } finally {
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}

function validate_registration(array $post): array
{
    $record = [
        'id' => ticket_id(),
        'name' => clean_text($post['fi-sender-fullName'] ?? ''),
        'email' => clean_text($post['fi-sender-email'] ?? ''),
        'phone' => clean_text($post['fi-sender-phone'] ?? ''),
        'from' => clean_text($post['fi-sender-city'] ?? ''),
        'tenure' => clean_text($post['fi-select-tenure'] ?? ''),
        'holdings' => clean_text($post['fi-select-holdings'] ?? ''),
        'wallet' => clean_text($post['fi-select-wallet'] ?? ''),
        'source' => 'form',
        'createdAt' => gmdate('c'),
    ];

    $errors = [];
    if ($record['name'] === '' || $record['email'] === '' || $record['phone'] === '' || $record['from'] === '') {
        $errors[] = 'Fill every field before reserving.';
    }
    if ($record['email'] !== '' && !filter_var($record['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if ($record['phone'] !== '' && !preg_match('/^\+?[0-9\s().-]{7,20}$/', $record['phone'])) {
        $errors[] = 'Phone needs a country code, e.g. +447700900123.';
    }
    if ($record['tenure'] === '' || $record['holdings'] === '' || $record['wallet'] === '') {
        $errors[] = 'Fill every field before reserving.';
    }

    return [$record, array_values(array_unique($errors))];
}

function json_input(): array
{
    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function json_response(array $body, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function header_value(string $name): string
{
    $key = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
    if (isset($_SERVER[$key])) {
        return (string) $_SERVER[$key];
    }
    if (function_exists('getallheaders')) {
        foreach (getallheaders() as $k => $v) {
            if (strcasecmp((string) $k, $name) === 0) {
                return (string) $v;
            }
        }
    }
    return '';
}

function timing_equal(string $a, string $b): bool
{
    if (function_exists('hash_equals')) {
        return hash_equals($a, $b);
    }
    return $a === $b;
}
