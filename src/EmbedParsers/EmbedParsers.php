<?php

namespace Hyvor\Unfold\EmbedParsers;

use Hyvor\Unfold\EmbedParsers\Exception\ParserException;
use Hyvor\Unfold\EmbedParsers\Platforms\Reddit;
use Hyvor\Unfold\EmbedParsers\Platforms\Tiktok;
use Hyvor\Unfold\EmbedParsers\Platforms\Twitter;
use Hyvor\Unfold\EmbedParsers\Platforms\Youtube;
use Hyvor\Unfold\UnfoldConfigObject;

class EmbedParsers
{
    /**
     * @var EmbedParserAbstract[]
     */
    public const PARSERS = [
        Youtube::class,
        Reddit::class,
        Tiktok::class,
        Twitter::class,
        Reddit::class,
    ];

    /**
     * @throws ParserException
     */
    public static function parse(
        string $url,
        ?UnfoldConfigObject $config = null,
    ): ?OEmbedResponse {
        foreach (self::PARSERS as $parserClass) {
            $parser = new $parserClass($url, $config);
            if ($parser->match()) {
                return $parser->parse();
            }
        }
    }

}
