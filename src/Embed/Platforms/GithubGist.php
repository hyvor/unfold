<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;

class GithubGist extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public function regex()
    {
        return [
            'https://gist.github.com/.*',
        ];
    }

    public function getEmbedHtml($matches): string
    {
        return "<script src=\"{$this->config->url}.js\"></script>";
    }
}
