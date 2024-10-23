<?php

namespace Hyvor\Unfold\Embed;

use Hyvor\Unfold\Exception\EmbedUnableToResolveException;
use Hyvor\Unfold\Exception\EmbedParserException;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\UnfoldCallContext;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\Unfolded\Unfolded;

class Embed
{
    /**
     * @return string[]
     */
    public static function getParsers(): array
    {
        $namespace = __NAMESPACE__ . '\\Platforms\\';
        return array_map(
            fn($file) => $namespace . pathinfo((string)$file, PATHINFO_FILENAME),
            (array)glob(__DIR__ . '/Platforms/*.php')
        );
    }

    /**
     * @throws EmbedParserException
     */
    public static function parse(
        string $url,
        ?UnfoldConfig $config = null,
    ): EmbedResponseObject {
        foreach (self::getParsers() as $parserClass) {
            /** @var EmbedParserAbstract $parser */
            $parser = new $parserClass($url, $config);
            if ($matches = $parser->match()) {
                return $parser->parse($matches);
            }
        }
        throw new EmbedUnableToResolveException();
    }

    /**
     * @throws UnfoldException
     */
    public static function getUnfoldedObject(
        string $url,
        UnfoldCallContext $context,
    ): Unfolded {
        $oembed = self::parse($url, $context->config);

        return Unfolded::fromEmbed(
            $oembed,
            $url,
            $context
        );
    }

}
