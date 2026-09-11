<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/includes/bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/webhooks.php';

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

if ($method === 'GET') {
    json_response([
        'ok' => true,
        'endpoint' => '/api/webhooks/forminit',
        'expect' => 'POST form.submitted',
    ]);
}

if ($method !== 'POST') {
    json_response(['ok' => false, 'error' => 'method not allowed'], 405);
}

$raw = file_get_contents('php://input') ?: '';
$result = ingest_lead_webhook($raw, $config, 'forminit');
json_response($result['body'], $result['status']);
