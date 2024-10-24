<script>
	import { CodeBlock } from '@hyvor/design/components';
	import Demo from '../demo/Demo.svelte';
</script>

<h1>Hyvor Unfold</h1>

<p>
	Hyvor Unfold is an open-source API that can fetch metadata from URLs for <strong
		>link previews</strong
	>
	and <strong>embeds</strong>. You can also use the Docker image to run this as a fully-fledged API.
</p>

<p>Visit these pages to get started:</p>

<ul>
	<li>
		<a href="/php">PHP Library</a>: Use the PHP library in your PHP projects.
	</li>
	<li>
		<a href="/docker">Docker Image</a>: Run the API via Docker.
	</li>
</ul>

<Demo />

<h2 id="link-previews">1. Link Previews</h2>

<p>
	The main feature of Hyvor Unfold is fetching metadata from URLs for link previews. You can use
	this to show a preview of a URL in your website or app. In the <a href="/php">PHP Library</a>, it
	would look like this:
</p>

<CodeBlock
	language="js"
	code={`
use Hyvor\\Unfold\\Unfold;

$data = Unfold::unfold('https://hyvor.com');
`}
/>

<p>
	You can then use the <code>$data</code> object to access the metadata and show the link preview:
</p>

<CodeBlock
	language="js"
	code={`
$data->title;
$data->description;
$data->thumbnailUrl;
`}
/>

<h3 id="how-it-works">How link previews works</h3>

<p>
	When you call the <code>unfold</code> method, we send a <code>GET</code> request to the URL and parse
	the metadata from the HTML. This is done using the following:
</p>

<ul>
	<li>
		<code>{'<title>'}</code> and <code>{'<meta name="description">'}</code> tags for the title and description.
	</li>
	<li>
		<a href="https://ogp.me/" target="_blank">Open Graph Protocol</a> tags
	</li>
	<li>
		<a href="https://developer.x.com/en/docs/x-for-websites/cards/overview/markup" target="_blank"
			>Twitter Cards Markup</a
		> tags
	</li>
	<li>
		JSON-LD and Microdata (<a href="https://schema.org/" target="_blank">Schema.org</a>)
	</li>
</ul>

<h2 id="embeds">2. Embeds</h2>

<p>
	The next feature of Hyvor Unfold is converting URLs to embed HTML codes. For example, you can
	embed a YouTube video or a tweet in your website or app instead of showing a link preview. In the
	<a href="/php">PHP Library</a>, it would look like this:
</p>

<CodeBlock
	language="js"
	code={`
use Hyvor\\Unfold\\Unfold;
use Hyvor\\Unfold\\UnfoldConfig;
use Hyvor\\Unfold\\Method;

$html = Unfold::unfold(
    'https://youtube.com/...',
    new UnfoldConfig(
        method: Method::EMBED,
    )
);
`}
/>

<h3 id="embed-platforms">Embed Platforms</h3>
