<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\Link\Link;
use Hyvor\Unfold\Unfolded\UnfoldedEmbed;
use Hyvor\Unfold\Unfolded\UnfoldedLink;

class Unfold
{

    /**
     * @throws UnfoldException
     */
    public static function link(string $url, UnfoldConfig $config = null): UnfoldedLink
    {
        return self::runUnfold($url, $config);
    }

    /**
     * @throws UnfoldException
     */
    public static function embed(string $url, UnfoldConfig $config = null): UnfoldedEmbed
    {
        return self::runUnfold($url, $config, true);
    }

    /**
     * @template T of bool
     * @param T $embed
     * @return ($embed is true ? UnfoldedEmbed : UnfoldedLink)
     * @throws UnfoldException
     */
    private static function runUnfold(
        string $url,
        UnfoldConfig $config = null,
        bool $embed = false,
    ) {
        $config ??= new UnfoldConfig();
        $config->start($url);

        if ($embed) {
            return Embed::unfold($config);
        } else {
            return Link::unfold($config);
        }
    }
}
