<?php

use Hyvor\Unfold\Embed\Iframe\PrivacyIframe;
use Hyvor\Unfold\Unfold;
use Hyvor\Unfold\UnfoldMethod;

include 'vendor/autoload.php';

$url = $_GET['url'];
$embed = Unfold::unfold($url, UnfoldMethod::EMBED);

header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');
echo PrivacyIframe::wrap((string)$embed->embed);
exit;