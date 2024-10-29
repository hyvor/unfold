<?php

namespace Hyvor\Unfold\Tests\Unit\Link\Metadata;

use Hyvor\Unfold\Link\Metadata\MetadataDateTime;

it('serializes DataTimeImmutable object as a string', function () {
    $dateTime = new MetadataDateTime('2021-10-10 10:10:10');
    expect(json_encode($dateTime))->toBe('"2021-10-10T10:10:10+00:00"');
});
