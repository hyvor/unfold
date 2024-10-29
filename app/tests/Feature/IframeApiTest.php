<?php
namespace Tests\Feature;

it('returns embed html', function () {
    $response = $this->getJson('/iframe?'.http_build_query([
        'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
    ]));

    $response->assertStatus(200);
    $html = $response->getContent();

    expect($html)->toContain('<html>')
        ->and($html)->toContain('<body style="margin:0;overflow:hidden">')
        ->and($html)->toContain('<div style="position:relative;left:0;width:100%;height:0;padding-bottom:56.25%;"><iframe')
        ->and($html)->toContain('src="https://www.youtube.com/embed/9bZkp7q19f0"')
        ->and($html)->toContain('style="position: absolute;top:0;left:0;width:100%;height:100%;border:0;"')
        ->and($html)->toContain('allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"></iframe>')
        ->and($html)->toContain('const height = document.documentElement.scrollHeight;')
        ->and($html)->toContain('function sendDelayedHeight() {')
        ->and($html)->toContain('const mutation = new window.MutationObserver(sendDelayedHeight);')
        ->and($html)->toContain(`document.addEventListener('resize', sendDelayedHeight);`);
});

it('returns error for invalid url', function () {
    $response = $this->getJson('/iframe?'.http_build_query([
        'url' => 'https://invalid.url',
    ]));
    $response->assertStatus(200);
    $response->assertSee('This URL cannot be embedded.');
});