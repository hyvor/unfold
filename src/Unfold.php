<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\Link\Link;
use Hyvor\Unfold\Unfolded\Unfolded;

class Unfold
{
    /**
     * @throws UnfoldException
     */
    public static function unfold(
        string $url,
        UnfoldMethod $method = UnfoldMethod::LINK,
        UnfoldConfig $config = null,
    ): Unfolded {
        $config ??= new UnfoldConfig();
        $config->start($url, $method);

        if ($method === UnfoldMethod::LINK) {
            return Link::getUnfoldedObject($config);
        } elseif ($method === UnfoldMethod::EMBED) {
            return Embed::getUnfoldedObject($config);
        } else {
            // both
            // TODO:
            throw new \Exception('Not implemented yet'); // @codeCoverageIgnore
        }
    }
}
