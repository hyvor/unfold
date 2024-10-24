<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;

class Youtube extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public function regex()
    {
        return [
            /**
             * The following are taken from the oEmbed providers JSON
             *
             * {
             *      "https://*.youtube.com/watch*",
             *      "https://*.youtube.com/v/*",
             *      "https://youtu.be/*",
             *      "https://*.youtube.com/playlist?list=*",
             *      "https://youtube.com/playlist?list=*",
             *      "https://*.youtube.com/shorts*",
             *      "https://youtube.com/shorts*",
             *      "https://*.youtube.com/embed/*",
             *      "https://*.youtube.com/live*",
             *      "https://youtube.com/live*"
             * }
             */

            // youtube.com watch
            "https://.*\.youtube\.com/watch\?(?:[^&]+&)*v=([a-zA-Z0-9_-]+)",
            // youtube.com v
            "https://.*\.youtube\.com/v/([a-zA-Z0-9_-]+)",
            // youtu.be
            "https://youtu\.be/([a-zA-Z0-9_-]+)",
            // playlist
            "https://(?:.*\.)?youtube\.com/playlist\?list=([a-zA-Z0-9_-]+)",
            // shorts
            "https://(?:.*\.)?youtube\.com/shorts/([a-zA-Z0-9_-]+)",
            // embed
            "https://.*\.youtube\.com/embed/([a-zA-Z0-9_-]+)",
            // live
            "https://(?:.*\.)?youtube\.com/live/([a-zA-Z0-9_-]+)",

            /**
             * Other URLS
             */
            // user
            // note: username is different from @code handles
            // so, there's no way to convert youtube.com/@code to youtube.com/user/code
            "https://(?:.*\.)?youtube\.com/user/([a-zA-Z0-9_-]+)",

        ];
    }

    public function getEmbedHtml($matches): string
    {
        $id = $matches[1] ?? '';

        $isShort = str_contains($this->config->url, '/shorts/');
        $isPlaylist = str_contains($this->config->url, '/playlist?list=');
        $isUser = str_contains($this->config->url, '/user/');

        $padding = round(100 * ($isShort ? 16 / 9 : 9 / 16), 2);

        $embedPrefix = "https://www.youtube.com/embed";
        if ($isPlaylist) {
            $embedUrl = "$embedPrefix?listType=playlist&list=$id";
        } elseif ($isUser) {
            $embedUrl = "$embedPrefix?listType=user_uploads&list=$id";
        } else {
            $embedUrl = "$embedPrefix/$id";
        }

        $html = <<<HTML
<div style="position:relative;left:0;width:100%;height:0;padding-bottom:$padding%;"><iframe src="$embedUrl" style="position: absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"></iframe></div>
HTML;

        if ($isShort) {
            // set max width same as the youtube player
            $html = '<div style="width:calc(56.25vh - 54px);min-width:315px;max-width:100%">' . $html . '</div>';
        }

        return $html;
    }
}
