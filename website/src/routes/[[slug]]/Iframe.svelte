<script>
	import { Callout, CodeBlock } from '@hyvor/design/components';
</script>

<h1>Privacy Iframe</h1>

<p>
	Adding embed codes directly to your website is a <strong>privacy concern</strong> since most of
	the time they include Javascript libraries that can access your page and user's data. Using an
	<strong>iframe to wrap the embed code</strong> is the best way to prevent this.
</p>

<h2 id="docker">Docker Image</h2>

<p>
	If you are using the <a href="/docker">Docker image</a>, the iframe endpoint is already included.
	On your website, use iframes with `src` set to <code>/iframe?url=my-url</code> to embed content.
</p>

<CodeBlock
	code={`
<iframe src="https://unfold.example.org/iframe?url=https://url-to-embed.com"></iframe>
`}
/>

<h2 id="iframe-endpoint">PHP Library</h2>

<p>
	If you are using the <a href="/php">PHP Library</a>, you have to set up an endpoint for the
	iframe. Here is an example with Laravel:
</p>

<CodeBlock
	code={`
use Hyvor\\Unfold\\Unfold;
use Hyvor\\Unfold\\Exceptions\\UnfoldException;
use Illuminate\\Http\\Request;

class IframeController
{

    public function getIframe(Request $request)
    {
        $url = $request->input('url');

        try {
            $data = Unfold::unfold($url);
            return PrivacyIframe::inner($data);
        } catch (UnfoldException) {
            // handle the exception
        }
    }

}    
`}
	language="js"
/>
