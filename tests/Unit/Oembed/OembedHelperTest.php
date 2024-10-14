<?php

namespace Hyvor\Unfold\Tests\Unit\Oembed;

use Hyvor\Unfold\Oembed\Oembed;

it('get embed data', function () {

    $url = 'https://www.youtube.com/watch?v=c0uLtuZufrg';
    expect(Oembed::getEmbedData(Oembed::checkOembedSupport($url), $url)['author_url'])->toBe('https://www.youtube.com/@Team-2FORTY2');

});

it('gets the provider url', function () {

    expect(Oembed::getProviderUrl('https://www.youtube.com/watch?v=azAXTKkbf64'))->toBe('https://www.youtube.com');
    expect(Oembed::getProviderUrl('http://www.youtube.com/watch?v=azAXTKkbf64'))->toBe('http://www.youtube.com');

    expect(Oembed::getProviderUrl('https://www.facebook.com/photo/?fbid=973771754783068&set=a.614610054032575'))->toBe('https://www.facebook.com');
    expect(Oembed::getProviderUrl('https://m.facebook.com/photo/?fbid=973771754783068&set=a.614610054032575'))->toBe('https://m.facebook.com');
    expect(Oembed::getProviderUrl('http://www.facebook.com/photo/?fbid=973771754783068&set=a.614610054032575'))->toBe('http://www.facebook.com');

    expect(Oembed::getProviderUrl('tcp://www.youtube.com'))->toBeNull();

});

it('checks if oembed is supported', function () {

    expect(Oembed::checkOembedSupport('https://www.youtube.com/watch?v=azAXTKkbf64')['url'])->toBe('https://www.youtube.com/oembed');
    expect(Oembed::checkOembedSupport('https://www.facebook.com/photo/?fbid=973771754783068&set=a.614610054032575')['url'])->toBe('https://graph.facebook.com/v16.0/oembed_page');
    expect(Oembed::checkOembedSupport('https://www.linkedin.com/posts/sathnindu_for-the-final-evaluation-of-my-3rd-year-module-activity-7250970881814880256-Zzcv?utm_source=share&utm_medium=member_desktop'))->toBeNull();

});