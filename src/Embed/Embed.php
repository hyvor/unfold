<?php

namespace Hyvor\Unfold\Embed;

use Hyvor\Unfold\Embed\Platforms\Reddit;
use Hyvor\Unfold\Embed\Platforms\Tiktok;
use Hyvor\Unfold\Embed\Platforms\Twitter;
use Hyvor\Unfold\Embed\Platforms\Youtube;
use Hyvor\Unfold\Exception\EmbedUnableToResolveException;
use Hyvor\Unfold\Exception\EmbedParserException;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\UnfoldCallContext;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\Unfolded\Unfolded;
use Hyvor\Unfold\UnfoldMethod;

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
     * @throws EmbedParserException
     */
    public static function parse(
        string $url,
        ?UnfoldConfig $config = null,
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
     * @return $context->method is EmbedMethodEnum::EMBED ? Unfolded : ?Unfolded
     * @throws UnfoldException
     */
    public static function getUnfoldedObject(
        string $url,
        UnfoldCallContext $context,
    ) {
        $oembed = self::parse($url, $context->config);

        if ($oembed === null) {
            if ($context->method === UnfoldMethod::EMBED) {
                throw new EmbedUnableToResolveException();
            } else {
                return null;
            }
        }

        return Unfolded::fromEmbed(
            $oembed,
            $url,
            $context
        );
    }

}
