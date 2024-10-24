<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\GithubGist;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;

it('github gist urls', function (string $url) {
    $parser = new GithubGist(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://gist.github.com/me/my',
    'https://gist.github.com/kalinchernev/486393efcca01623b18d'
]);

it('returns js script', function () {
    $parser = new GithubGist(UnfoldConfig::withUrlAndMethod('https://gist.github.com/me/my', UnfoldMethod::EMBED));
    $html = $parser->getEmbedHtml($parser->match());
    expect($html)->toBe('<script src="https://gist.github.com/me/my.js"></script>');
});
