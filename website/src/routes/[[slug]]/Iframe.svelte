<script>
	import { CodeBlock } from '@hyvor/design/components';
</script>

<h1>Privacy Iframe</h1>

<p>
	Adding embed codes directly to your website can be a <strong>security/privacy concern</strong>
	since they are provided by third parties and may include Javascript that can be used for tracking or
	other malicious purposes. Using a <strong>cross-origin iframe</strong> is the best way to prevent access
	to the parent window and protect your users' privacy.
</p>

<h2 id="cross-origin-iframe">Cross-Origin Iframe</h2>

<h3 id="iframe-methods">Why Cross-Origin Iframe is the Best Method to Sandbox Content?</h3>

<p>
	We have tested multiple methods to sandbox iframe content and found that using a cross-origin
	iframe is the best way (you can still other methods if you want):
</p>

<ul>
	<li>
		<strong>Using srcdoc</strong>: Using iframe <code>srcdoc</code> for content provides a seperate
		<strong>about:</strong> origin for the iframe content, but multiple platforms (Reddit, X) do not
		support it correctly.
	</li>
	<li>
		<strong>Using data URLs</strong>: Using data URLs for iframe content has the same problems as
		srcdoc. Many platforms do not support it.
	</li>
	<li>
		<strong>Same-origin iframe</strong>: We could use a same-origin iframe with the
		<code>sandbox</code>
		attribute, but most embeds fail without the <code>allow-same-origin</code> attribute, which defeats
		the purpose of sandboxing.
	</li>
	<li>
		<strong>Cross-origin iframe</strong>: Using a cross-origin iframe with the <code>sandbox</code>
		and <code>allow-same-origin</code> attributes is the best way to sandbox content. It gives the embed
		access to local storage, etc. but in a seperate context, so it cannot access the parent window's
		local storage or other sensitive information. All currently supported platforms in Hyvor Unfold are
		compatible with this method.
	</li>
</ul>

<h3 id="iframe-cross-origin-what-is-it">What is a Cross-Origin Iframe?</h3>

<p>
	If your website is on <code>example.org</code>, you can use a subdomain,
	<code>unfold.example.org</code>, or another domain, <code>example.net</code>, for the iframe
	endpoint. This makes the iframe cross-origin by default. The content inside the iframe cannot
	access the parent window, and the parent window cannot access the content inside the iframe.
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
    sandbox="allow-scripts allow-same-origin allow-popups"
	allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"
></iframe>
`}
/>

<p>
	See the <a href="#sandbox">sandbox</a> and <a href="#allow">allow</a> attributes for more information.
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
            $data = Unfold::unfold($url, UnfoldMethod::EMBED);
        } catch (UnfoldException) {
            // handle the exception
        }

        return PrivacyIframe::wrap($data->embed);
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
	<a href="https://github.com/hyvor/unfold/blob/main/src/Embed/Iframe/child.js"> child.js </a> script
	that will send the height of the content to the parent window.
</p>

<p>
	On your website, you have to include the <a
		href="https://github.com/hyvor/unfold/blob/main/src/Embed/Iframe/parent.js"
	>
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

<h2 id="sandbox">Sandbox and Cross-Origin</h2>

<h3 id="cross-origin">Cross-Origin Iframe</h3>

<p>
	<strong>Our recommendation</strong>: Keep the unfold iframe endpoint on a separate subdomain (e.g.
	unfold.example.org) from your main website (e.g. example.org). This makes the iframe cross origin
	by default and prevents access to the parent window.
</p>

<p>This is the minimal setup required for the iframe to work cross-domain:</p>

<CodeBlock
	code={`
	sandbox="allow-scripts allow-same-origin allow-popups allow-presentation"
`}
/>

<ul>
	<li>
		<code>allow-scripts</code>: Allows the content inside the iframe to execute scripts.
	</li>
	<li>
		<code>allow-same-origin</code>: Gives access to local storage, etc. in a seperate context (it
		cannot access the parent window's local storage).
	</li>
	<li>
		<code>allow-popups</code>: Allows the content to open popups.
	</li>
</ul>

<h3 id="same-origin">Same-Origin Iframe</h3>

<p>
	If your website (e.g. example.org) and the unfold iframe endpoint (e.g. example.org/unfold-iframe)
	are on the same domain, you can use the following sandbox attribute:
</p>

<h2 id="allow">Allow Attribute</h2>

<p>
	The <code>allow</code> attribute is used to enable certain features in the iframe. We recommend the
	following to make sure embeds, especially video players, work correctly:
</p>

<CodeBlock
	code={`
	allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"
`}
/>
