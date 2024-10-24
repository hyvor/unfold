<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Instagram;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;

it('matches instagram post', function () {
    $url = 'https://www.instagram.com/p/DA5VlaMK1Wc/';
    $parser = new Instagram(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match['id'])->toBe('DA5VlaMK1Wc');

    $response = $parser->parse($match);

    $urlWithParams = 'https://www.instagram.com/p/DA5VlaMK1Wc/?utm_source=ig_embed&utm_campaign=loading';

    expect($response->html)->toContain(
        '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . $urlWithParams . '" data-instgrm-version="14"'
    );
    expect($response->html)->toContain("<a href=\"$urlWithParams\"");
    expect($response->html)->toContain('<script async src="//www.instagram.com/embed.js">');
});

it('adds shared by caption to username post links', function () {
    // https://www.instagram.com/{username}/p/{post_id}

    $url = 'https://www.instagram.com/emmafarrarons/p/DA5VlaMK1Wc/';
    $parser = new Instagram(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match['username'])->toBe('emmafarrarons');
    expect($match['id'])->toBe('DA5VlaMK1Wc');

    $response = $parser->parse($match);
    expect($response->html)->toContain('A post shared by @emmafarrarons');

    $urlWithParams = 'https://www.instagram.com/p/DA5VlaMK1Wc/?utm_source=ig_embed&utm_campaign=loading';
    expect($response->html)->toContain(
        '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . $urlWithParams . '" data-instgrm-version="14"'
    );
    expect($response->html)->toContain("<a href=\"$urlWithParams\"");
    expect($response->html)->toContain('<script async src="//www.instagram.com/embed.js">');
});

it('matches reel', function () {
    $url = 'https://www.instagram.com/reel/C6H039Ctw_b/';
    $parser = new Instagram(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match['id'])->toBe('C6H039Ctw_b');
    expect($match['type'])->toBe('reel');

    $response = $parser->parse($match);

    $urlWithParams = 'https://www.instagram.com/reel/C6H039Ctw_b/?utm_source=ig_embed&utm_campaign=loading';
    expect($response->html)->toContain(
        '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . $urlWithParams . '" data-instgrm-version="14"'
    );
    expect($response->html)->toContain("<a href=\"$urlWithParams\"");
    expect($response->html)->toContain('<script async src="//www.instagram.com/embed.js">');
});

//it('test', function () {
//    $url = 'https://www.instagram.com/tv/CVdJkLFr1du/';
//    $parser = new Instagram($url);
//    $match = $parser->match();
//    $response = $parser->parse($match);
//    dd($response->html);
//});

it('matches instagram URLs', function (string $url, array $matches) {
    $parser = new Instagram(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match)->toBeArray();
    foreach ($matches as $key => $value) {
        expect($match[$key])->toBe($value);
    }
})->with([

    // direct post link
    [
        'http://instagram.com/p/mBilj1tJ1c',
        ['id' => 'mBilj1tJ1c', 'type' => 'p']
    ],
    [
        'https://instagram.com/p/mBilj1tJ1c',
        ['id' => 'mBilj1tJ1c', 'type' => 'p']
    ],
    [
        'https://www.instagram.com/p/mBilj1tJ1c',
        ['id' => 'mBilj1tJ1c', 'type' => 'p']
    ],
    [
        'https://instagr.am/p/DA5VlaMK1Wc',
        ['id' => 'DA5VlaMK1Wc', 'type' => 'p']
    ],
    [
        'https://www.instagr.am/p/DA5VlaMK1Wc',
        ['id' => 'DA5VlaMK1Wc', 'type' => 'p']
    ],

    // user profile post link
    [
        'http://instagram.com/emmafarrarons/p/mBilj1tJ1c',
        ['username' => 'emmafarrarons', 'id' => 'mBilj1tJ1c', 'type' => 'p']
    ],
    [
        'https://instagram.com/emmafarrarons/p/mBilj1tJ1c',
        ['username' => 'emmafarrarons', 'id' => 'mBilj1tJ1c', 'type' => 'p']
    ],
    [
        'https://www.instagram.com/emmafarrarons/p/mBilj1tJ1c',
        ['username' => 'emmafarrarons', 'id' => 'mBilj1tJ1c', 'type' => 'p']
    ],
    [
        'https://instagr.am/emmafarrarons/p/mBilj1tJ1c',
        ['username' => 'emmafarrarons', 'id' => 'mBilj1tJ1c', 'type' => 'p']
    ],

    // reel
    [
        'https://www.instagram.com/reel/C6H039Ctw_b/',
        ['id' => 'C6H039Ctw_b', 'type' => 'reel']
    ],
    [
        'https://instagr.am/reel/C6H039Ctw_b/',
        ['id' => 'C6H039Ctw_b', 'type' => 'reel']
    ],

    // tv
    [
        'https://www.instagram.com/tv/C6H039Ctw_b/',
        ['id' => 'C6H039Ctw_b', 'type' => 'tv']
    ]

]);
