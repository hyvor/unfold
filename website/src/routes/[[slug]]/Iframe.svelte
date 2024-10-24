<script>
	import { Callout, CodeBlock } from '@hyvor/design/components';
</script>

<h1>Privacy Iframe</h1>

<p>
	Adding embed codes directly to your website is a <strong>privacy concern</strong> since they may
	include Javascript that can be used for tracking. Using an
	<strong>iframe to wrap the embed code</strong> is the best way to prevent this.
</p>

<h2 id="docker">Docker Image</h2>

<p>
	If you are using the <a href="/docker">Docker image</a>, the iframe endpoint is already included.
	On your website, use iframes with <code>src</code> set to <code>/iframe?url=my-url</code> to embed
	content.
</p>

<CodeBlock
	code={`
<iframe
    src="https://unfold.example.org/iframe?url=https://url-to-embed.com"
    sandbox="allow-scripts allow-modals allow-popups"
></iframe>
`}
/>

<p>
	The <code>sandbox</code> attribute is only required if you are hosting the Docker image on the same
	domain as the parent website (Same Origin Policy). It's purpose is to prevent the embedded content
	from accessing the parent website's window.
</p>

<h2 id="iframe-endpoint">PHP Library</h2>

<p>
	If you are using the <a href="/php">PHP Library</a>, you have to set up an endpoint within your
	website for the iframe. Here is an example with Laravel, but you can use any PHP framework.
</p>

<CodeBlock
	code={`
    Route::get('/unfold-iframe', 'IframeController@getIframe');
`}
	language="js"
/>

<CodeBlock
	code={`
use Hyvor\\Unfold\\Unfold;
use Hyvor\\Unfold\\Exceptions\\UnfoldException;
use Hyvor\\Unfold\\Embed\\Iframe\\PrivacyIframe;
use Illuminate\\Http\\Request;

class IframeController
{

    public function getIframe(Request $request)
    {
        $url = $request->input('url');

        try {
            $data = Unfold::unfold($url);
        } catch (UnfoldException) {
            // handle the exception
        }

        return PrivacyIframe::wrap($data);
    }

}    
`}
	language="js"
/>

<p>
	The <code>PrivacyIframe::wrap</code> method will wrap the embed code in a full HTML document with
	sensible defaults. It will also include the necessary Javascript for
	<a href="#resize">resizing the iframe</a> based on the content.
</p>

<p>You can then use the iframe in your website like this:</p>

<CodeBlock
	code={`
<iframe 
    src="/unfold-iframe?url=https://url-to-embed.com"
    sandbox="allow-scripts allow-modals allow-popups"
></iframe>
`}
/>

<h2 id="resize">Resizing the iframe</h2>

<p>
	Iframe resizing is a common problem when embedding content. The content inside the iframe may
	change its height based on user interactions. Since Javascript inside the iframe cannot access the
	parent window, we need to use a <strong>postMessage</strong> to communicate between the parent and
	child windows.
</p>

<p>
	When you call the <code>PrivacyIframe::wrap</code> method, it will include
	<a href="./blob/main/src/Embed/Iframe/child.js"> child.js </a> script that will send the height of
	the content to the parent window.
</p>

<p>
	On your website, you have to include the <a href="./blob/main/src/Embed/Iframe/parent.js">
		parent.js
	</a> script. This script will listen to the messages from the child window and resize the iframe accordingly.
</p>

<CodeBlock
	code={`
<` +
		`script src="/parent.js"><` +
		`/script>
`}
/>

<p>Or, since the code is pretty small, feel free to copy it to your source code directly.</p>
