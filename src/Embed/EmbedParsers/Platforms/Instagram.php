<?php

namespace Hyvor\Unfold\Embed\EmbedParsers\Platforms;

use Hyvor\Unfold\Embed\EmbedParsers\EmbedParserAbstract;

class Instagram extends EmbedParserAbstract
{

    public function oEmbedRegex()
    {
        return [
            "http://instagram.com/.*/p/.*,",
            "http://www.instagram.com/.*/p/.*,",
            "https://instagram.com/.*/p/.*,",
            "https://www.instagram.com/.*/p/.*,",
            "http://instagram.com/p/.*",
            "http://instagr.am/p/.*",
            "http://www.instagram.com/p/.*",
            "http://www.instagr.am/p/.*",
            "https://instagram.com/p/.*",
            "https://instagr.am/p/.*",
            "https://www.instagram.com/p/.*",
            "https://www.instagr.am/p/.*",
            "http://instagram.com/tv/.*",
            "http://instagr.am/tv/.*",
            "http://www.instagram.com/tv/.*",
            "http://www.instagr.am/tv/.*",
            "https://instagram.com/tv/.*",
            "https://instagr.am/tv/.*",
            "https://www.instagram.com/tv/.*",
            "https://www.instagr.am/tv/.*",
            "http://www.instagram.com/reel/.*",
            "https://www.instagram.com/reel/.*",
            "http://instagram.com/reel/.*",
            "https://instagram.com/reel/.*",
            "http://instagr.am/reel/.*",
            "https://instagr.am/reel/.*"
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://graph.facebook.com/v16.0/instagram_oembed';
    }
}