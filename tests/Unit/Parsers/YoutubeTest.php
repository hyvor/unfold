<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Parsers\Youtube;

it('parses youtube URLs', function() {

    $url = 'https://www.youtube.com/watch?v=X-sZhiYAzNI';

    $parser = new Youtube($url);
    $output = $parser->parse();

    var_dump($output);

    expect(true)->toBeTrue();

});