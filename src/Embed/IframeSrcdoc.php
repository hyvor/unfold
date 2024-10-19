<?php

namespace Hyvor\Unfold\Embed;

class IframeSrcdoc
{

    public static function wrap(string $embed) : string
    {

        $embed = htmlspecialchars($embed, ENT_QUOTES, 'UTF-8');
        $hash = md5($embed);

        return <<<HTML
<iframe
    style="border:none;"
    srcdoc="<body style='margin:0'>
        $embed
        <script type='module'>
            sendHeight();
            
            const mutation = new MutationObserver(sendHeight);
            mutation.observe(document.body, {attributes: false, childList: true, subtree: true});

            window.addEventListener('load', sendHeight);
            window.addEventListener('resize', sendHeight);

            function sendHeight() {
                var height = document.body.scrollHeight;
                window.parent.postMessage({
                    type: 'unfold-embed-height',
                    hash: '$hash',
                    height: height
                }, '*');
            }
        </script>
    </body>"
    sandbox="allow-scripts allow-modals"
></iframe>
<script>
    window.addEventListener('message', function(event) {
        if (
            event.data.type === 'unfold-embed-height' &&
            event.data.hash === '$hash'
        ) {
            var iframe = document.querySelector('iframe');
            iframe.style.height = event.data.height + 'px';
        }
    });
</script>
HTML;

    }

}