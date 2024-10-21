<?php

namespace Hyvor\Unfold\EmbedParsers\Platforms;

use Hyvor\Unfold\EmbedParsers\EmbedParserAbstract;
use Hyvor\Unfold\EmbedParsers\EmbedParserCustomInterface;

class GithubGist extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public function regex()
    {
        return [
            'https://gist.github.com/.*',
        ];
    }

    public function getEmbedHtml(): string
    {
        return "<script src=\"$this->url.js\"></script>";
    }
}
