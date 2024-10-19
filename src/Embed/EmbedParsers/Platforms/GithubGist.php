<?php

namespace Hyvor\Unfold\Embed\EmbedParsers\Platforms;

use Hyvor\Unfold\Embed\EmbedParsers\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParsers\EmbedParserCustomInterface;

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