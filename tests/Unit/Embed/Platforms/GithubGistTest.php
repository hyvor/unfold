<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\GithubGist;

it('github gist urls', function (string $url) {
    $parser = new GithubGist($url);
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://gist.github.com/me/my',
    'https://gist.github.com/kalinchernev/486393efcca01623b18d'
]);

it('returns js script', function () {
    $parser = new GithubGist('https://gist.github.com/me/my');
    $html = $parser->getEmbedHtml($parser->match());
    expect($html)->toBe('<script src="https://gist.github.com/me/my.js"></script>');
});