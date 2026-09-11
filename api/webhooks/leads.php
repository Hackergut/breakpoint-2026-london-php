<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . '/includes/bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/webhooks.php';

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

if ($method === 'GET') {
    json_response([
        'ok' => true,
        'endpoint' => '/api/webhooks/leads',
        'expect' => 'POST JSON lead { name, email, phone, from, tenure, holdings, wallet }',
    ]);
}

if ($method !== 'POST') {
    json_response(['ok' => false, 'error' => 'method not allowed'], 405);
}

$raw = file_get_contents('php://input') ?: '';
$result = ingest_lead_webhook($raw, $config, 'leads');
json_response($result['body'], $result['status']);
