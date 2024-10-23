<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;

class FacebookVideo extends EmbedParserAbstract
{
    public const PRIORITY = 3;

    public function regex()
    {
        return [];
    }
}
