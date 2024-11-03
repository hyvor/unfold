<?php

use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\Unfold;

include 'vendor/autoload.php';

$url = $_GET['url'];
$type = $_GET['type'] ?? 'link';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$link = null;
try {
    if ($type === 'link') {
        $link = Unfold::link($url);
    } else {
        $link = [
            'embed' => Unfold::embed($url)->embed
        ];
    }
} catch (UnfoldException $e) {
    http_response_code(400);
    echo json_encode([
        'message' => $e->getMessage(),
    ]);
    die;
}

echo json_encode($link);
