<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Types\EmbedType;
use Hyvor\Unfold\Unfold;

it('handles oEmbed supported URLs', function () {

    $url = 'https://www.youtube.com/watch?v=c0uLtuZufrg';
    $data = Unfold::unfold($url);

    expect($data->type)->toBe(EmbedType::VIDEO);
    expect($data->author_url)->toBe('https://www.youtube.com/@Team-2FORTY2');
    expect($data)->toBe('hi');

});