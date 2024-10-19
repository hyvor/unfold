<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

interface EmbedParserOEmbedInterface
{

    /**
     * PCRE regex patterns to match the URL
     * Delimiter should not be added. ~ will be added automatically
     * / is safe to use without escaping
     * @return string[]
     */
    public function oEmbedRegex();

    public function oEmbedUrl(): ?string;

}