<?php

namespace Hyvor\Unfold\Embed;

use Hyvor\Unfold\Embed\Iframe\PrivacyIframe;
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

        $parsers = array_map(
            fn($file) => $namespace . pathinfo((string)$file, PATHINFO_FILENAME),
            (array)glob(__DIR__ . '/Platforms/*.php')
        );

        usort($parsers, fn($a, $b) => $b::PRIORITY <=> $a::PRIORITY);

        return $parsers;
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
     * @param string $url
     * @return array{parser: EmbedParserAbstract, matches: string[]}|null
     */
    public static function getMatchingParser(string $url): ?array
    {
        foreach (self::getParsers() as $parserClass) {
            /** @var EmbedParserAbstract $parser */
            $parser = new $parserClass($url);
            if ($parser->match()) {
                return [
                    'parser' => $parser,
                    'matches' => $parser->match(),
                ];
            }
        }
        return null;
    }

    /**
     * @throws UnfoldException
     */
    public static function getUnfoldedObject(
        string $url,
        UnfoldCallContext $context,
    ): Unfolded {
        $oembed = self::parse($url, $context->config);

        if ($context->config->embedIframeEndpoint && $oembed->html) {
            $oembed->html = PrivacyIframe::wrap($oembed->html);
        }

        return Unfolded::fromEmbed(
            $oembed,
            $url,
            $context
        );
    }

}
