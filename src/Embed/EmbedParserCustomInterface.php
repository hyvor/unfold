<?php

namespace Hyvor\Unfold\Embed;

interface EmbedParserCustomInterface
{
    /**
     * @param string[] $matches
     */
    public function getEmbedHtml(array $matches): string;

}
