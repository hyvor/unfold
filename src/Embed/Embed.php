<?php

namespace Hyvor\Unfold\Embed;

use Hyvor\Unfold\Exception\EmbedParserException;
use Hyvor\Unfold\Exception\EmbedUnableToResolveException;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\Unfolded\UnfoldedEmbed;

class Embed
{
    /**
     * @return string[]
     */
    public static function getParsers(): array
    {
        $namespace = __NAMESPACE__ . '\\Platforms\\';

        $parsers = array_map(
            fn ($file) => $namespace . pathinfo((string)$file, PATHINFO_FILENAME),
            (array)glob(__DIR__ . '/Platforms/*.php')
        );

        usort($parsers, fn ($a, $b) => $b::PRIORITY <=> $a::PRIORITY);

        return $parsers;
    }

    /**
     * @throws EmbedParserException
     */
    public static function parse(UnfoldConfig $config): string
    {
        foreach (self::getParsers() as $parserClass) {
            /** @var EmbedParserAbstract $parser */
            $parser = new $parserClass($config);
            if ($matches = $parser->match()) {
                return $parser->parse($matches);
            }
        }
        throw new EmbedUnableToResolveException();
    }

    /**
     * @return array{parser: EmbedParserAbstract, matches: string[]}|null
     */
    public static function getMatchingParser(string $url): ?array
    {
        foreach (self::getParsers() as $parserClass) {
            /** @var EmbedParserAbstract $parser */
            $parser = new $parserClass(UnfoldConfig::withUrl($url));
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
    public static function unfold(
        UnfoldConfig $config,
    ): UnfoldedEmbed {
        $html = self::parse($config);

        return new UnfoldedEmbed($config->url, $html, $config->duration());
    }
}
