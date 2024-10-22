<?php

use Hyvor\Unfold\Unfold;
use Hyvor\Unfold\UnfoldConfigObject;
use Hyvor\Unfold\UnfoldMethod;
use Hyvor\Unfold\UnfoldException;

require __DIR__ . '/vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/unfold') {

    if (!($_SERVER['REQUEST_METHOD'] === 'GET')) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method.'
        ]);
        exit;
    }

    $url = $_GET['url'] ?? '';

    $method = isset($_GET['method']) && UnfoldMethod::tryFrom($_GET['method'])
        ? UnfoldMethod::from($_GET['method'])
        : UnfoldMethod::LINK;

    $config = isset($_GET['config']) ? new UnfoldConfigObject(json_decode($_GET['config'], true)) : null;

    try {
        $response = Unfold::unfold($url, $method, $config);
    } catch (UnfoldException $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'data' => $response
    ]);
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid endpoint.'
    ]);
}
