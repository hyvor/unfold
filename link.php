<?php

use Hyvor\Unfold\Embed\Iframe\PrivacyIframe;
use Hyvor\Unfold\Unfold;

include 'vendor/autoload.php';

$url = $_GET['url'];
$link = Unfold::link($url);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($link);
