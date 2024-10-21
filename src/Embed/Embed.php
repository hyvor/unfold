<?php

namespace Hyvor\Unfold\Embed;

use Hyvor\Unfold\Embed\Exception\ParserException;
use Hyvor\Unfold\Embed\Exception\UnableToResolveEmbedException;
use Hyvor\Unfold\Embed\Platforms\Reddit;
use Hyvor\Unfold\Embed\Platforms\Tiktok;
use Hyvor\Unfold\Embed\Platforms\Twitter;
use Hyvor\Unfold\Embed\Platforms\Youtube;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\Objects\UnfoldRequestContextObject;
use Hyvor\Unfold\UnfoldConfigObject;
use Hyvor\Unfold\UnfoldException;
use Hyvor\Unfold\UnfoldMethodEnum;

class Embed
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
    ): ?EmbedResponseObject {
        foreach (self::PARSERS as $parserClass) {
            $parser = new $parserClass($url, $config);
            if ($parser->match()) {
                return $parser->parse();
            }
        }
        return null;
    }

    /**
     * @return $context->method is EmbedMethodEnum::EMBED ? UnfoldedObject : ?UnfoldedObject
     * @throws UnfoldException
     */
    public static function getUnfoldedObject(
        string $url,
        UnfoldRequestContextObject $context,
    ) {
        $oembed = self::parse($url, $context->config);

        if ($oembed === null) {
            if ($context->method === UnfoldMethodEnum::EMBED) {
                throw new UnableToResolveEmbedException();
            } else {
                return null;
            }
        }

        return UnfoldedObject::fromEmbed(
            $oembed,
            $url,
            $context
        );
    }

}
