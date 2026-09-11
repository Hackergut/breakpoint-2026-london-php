<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: index.php#register');
    exit;
}

[$record, $errors] = validate_registration($_POST);
if ($errors) {
    $formError = $errors[0];
    $pageTitle = $config['app_name'];
    include __DIR__ . '/index.php';
    exit;
}

try {
    save_lead($config['leads_file'], $record);
} catch (Throwable $e) {
    error_log('[register] save failed ' . $e->getMessage());
}

try {
    deliver_lead_to_telegram($config, $record);
} catch (Throwable $e) {
    error_log('[register] telegram failed ' . $e->getMessage());
}

$_SESSION['ticket'] = $record;
header('Location: index.php?reserved=1#register');
exit;
