<?php

use Hyvor\Unfold\Embed\Iframe\PrivacyIframe;

it('adds body', function () {
    $html = '<embed>test</embed>';

    $wrapped = PrivacyIframe::wrap($html);

    expect($wrapped)->toContain(
        '<html>
<body style="margin:0;overflow:hidden">
<embed>test</embed>
'
    );

    // child.js
    expect($wrapped)->toContain('document.documentElement.scrollHeight;');
});