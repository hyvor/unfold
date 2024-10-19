<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

use Hyvor\Unfold\UnfoldConfigObject;
use Hyvor\Unfold\Embed\EmbedParsers\Platforms\Reddit;
use Hyvor\Unfold\Embed\EmbedParsers\Platforms\Tiktok;
use Hyvor\Unfold\Embed\EmbedParsers\Platforms\Twitter;
use Hyvor\Unfold\Embed\EmbedParsers\Platforms\Youtube;

class EmbedParsers
{

    /**
     * @var EmbedParserAbstract[]
     */
    const PARSERS = [
        Youtube::class,
        Reddit::class,
        Tiktok::class,
        Twitter::class,
        Reddit::class,
    ];

    public static function parse(
        string              $url,
        ?UnfoldConfigObject $config = null,
    ) {
        foreach (self::PARSERS as $parserClass) {
            $parser = new $parserClass($url, $config);
            if ($parser->match()) {
                return $parser->parse();
            }
        }
    }

}