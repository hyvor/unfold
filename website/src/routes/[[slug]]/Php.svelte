<script>
	import { CodeBlock } from '@hyvor/design/components';
</script>

<h1>PHP Library</h1>

<p>Install the PHP library using composer:</p>

<CodeBlock code="composer require hyvor/unfold" />

<h2 id="emeds">Embeds</h2>

<p>
	Call <code>Unfold::embed()</code> to get the embed code for a URL of a
	<a href="/#embed-platforms">supported platform</a>. This returns an <code>UnfoldedEmbed</code> object.
</p>

<CodeBlock
	code={`
<?php

use Hyvor\\Unfold\\Unfold;
use Hyvor\\Unfold\\Exception\\EmbedUnableToResolveException;
use Hyvor\\Unfold\\Exception\\UnfoldException;

try {

    $embed = Unfold::embed('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    $embed->embed; // html code to embed
    $embed->durationMs; // duration to resolve the embed in milliseconds

} catch (EmbedUnableToResolveException) {
    // This URL did not match any of the supported platforms
} catch (UnfoldException $e) {
    // any other possible error
    // $e->getMessage();
}
`}
	language="js"
/>

<h2 id="link-previews">Link Previews</h2>

<p>
	Call <code>Unfold::link()</code> to get metadata of a URL. This returns an
	<code>UnfoldedLink</code> object.
</p>

<CodeBlock
	code={`
<?php

use Hyvor\\Unfold\\Unfold;
use Hyvor\\Unfold\\Exception\\UnfoldException;
use Hyvor\\Unfold\\Exception\\LinkScrapeException;

try {

    $link = Unfold::link('https://hyvor.com');

    $link->title;
    $link->description;
    $link->siteName;
    $link->siteUrl;
    $link->canonicalUrl;
    $link->publishedTime;
    $link->modifiedTime;
    $link->thumbnailUrl;
    $link->iconUrl;
    $link->locale;
    $link->authors;
    $link->tags;

    $link->durationMs;

} catch (LinkScrapeException $e) {
    // This URL could not be scraped due to non-200 status code or other reasons
    // $e->getMessage(); returns more details including the HTTP status
} catch (UnfoldException $e) {
    // any other possible error
    // $e->getMessage();
}
`}
	language="js"
/>

<h2 id="config">Config</h2>

<p>
	Both <code>embed()</code> and <code>link()</code> methods accept an optional second parameter that
	accepts a <code>Hyvor\Unfold\UnfoldConfig</code>.
</p>

<p>
	Here is an example with all the available configurations (feel free to read the comments in the
	code for more details):
</p>

<CodeBlock
	code={`
use Hyvor\\Unfold\\Unfold;
use Hyvor\\Unfold\\UnfoldConfig;

$url = 'https://hyvor.com';
$config = new UnfoldConfig(
    httpClient: new MyCustomPsr18Client(),
    httpMaxRedirects: 5,
    httpUserAgent: 'My Custom User Agent',
);
$link = Unfold::link($url, $config);
`}
	language="js"
/>

<h3 id="psr-18">PSR-18</h3>

<p>
	This library does not include an HTTP Client. Instead, it uses <code>php-http/discovery</code> to
	find a PSR-18 HTTP Client installed in your project. If you want to use a custom HTTP Client, you
	can pass it as the <code>httpClient</code> parameter in the <code>UnfoldConfig</code> object.
</p>

<p>
	Currently, an HTTP Client is only required for the <code>link()</code> method. The
	<code>embed()</code> method depends on regex to parse URLs into embeds.
</p>
