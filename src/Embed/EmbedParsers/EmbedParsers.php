<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

use Hyvor\Unfold\UnfoldConfig;

class EmbedParsers
{

    /**
     * @var EmbedParserAbstract[]
     */
    const PARSERS = [
        Youtube::class
    ];

    public static function parse(
        string $url,
        ?UnfoldConfig $config = null,
    ) {
        foreach (self::PARSERS as $parserClass) {
            $parser = new $parserClass($url, $config);
            if ($parser->match()) {
                return $parser->parse();
            }
        }
    }

}