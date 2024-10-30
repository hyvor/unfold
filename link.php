<?php

use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\Unfold;

include 'vendor/autoload.php';

$url = $_GET['url'];

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$link = null;
try {
    $link = Unfold::link($url);
} catch (UnfoldException $e) {
    http_response_code(400);
    echo json_encode([
        'message' => $e->getMessage(),
    ]);
    die;
}

echo json_encode($link);
