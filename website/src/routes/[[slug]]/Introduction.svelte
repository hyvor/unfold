<script>
	import { Callout } from '@hyvor/design/components';
	import DemoEmbed from '../demo/DemoEmbed.svelte';
	import { IconInfoCircle } from '@hyvor/icons';
	import DemoLink from '../demo/DemoLink.svelte';
	import OEmbedTag from './OEmbedTag.svelte';
</script>

<h1>Hyvor Unfold</h1>

<p>
	Hyvor Unfold is an open-source PHP library and self-hostable API for <strong
		>generating embed codes</strong
	>
	(Youtube, Twitter, and <a href="#embed-platforms">more</a>) and <strong>fetching metadata</strong>
	from URLs for link previews.
</p>

<p>Visit these pages to get started:</p>

<ul>
	<li>
		<a href="/php">PHP Library</a>: Use the PHP library in your PHP projects.
	</li>
	<li>
		<a href="/docker">Docker Hosting</a>: Run the API via Docker.
	</li>
</ul>

<h2 id="embeds">1. Embeds</h2>

<p>Hyvor Unfold can convert URLs from various platforms to embed HTML codes.</p>

<DemoEmbed />

<h3 id="embed-platforms">Supported Platforms</h3>

<ul>
	<li>
		<strong>Youtube</strong>: Videos, shorts, playlists, and channels
	</li>
	<li>
		<strong>Facebook</strong>: Posts, pages, videos, and reels
	</li>
	<li>
		<strong>Instagram</strong>: Posts and reels
	</li>
	<li>
		<strong>Twitter/X</strong>: Tweets
	</li>
	<li>
		<strong>Threads</strong>: Posts
	</li>
	<li>
		<strong>Reddit</strong>: Posts and subreddits
	</li>
	<li>
		<strong>Tiktok</strong>: Videos
	</li>
	<li>
		<strong>Github</strong>: Gists
	</li>
	<li>
		<strong>Bluesky</strong>
		<OEmbedTag />: Posts
	</li>
	<li>
		<strong>Tenor</strong>
		<OEmbedTag />: GIFs
	</li>
	<li>
		<strong>Giphy</strong>
		<OEmbedTag />: GIFs
	</li>
</ul>

<Callout type="info">
	<IconInfoCircle slot="icon" />
	When resolving embeds, we proritize regex-based methods to prevent needing to make API requests. If
	we can't resolve the embed using regex, we use <OEmbedTag /> endpoints if available.
</Callout>

<p>
	See our <a href="https://github.com/hyvor/unfold" target="_blank">policy</a> for adding new platforms.
</p>

<!-- <p>
	See <a href=""
</p> -->

<h2 id="link-previews">2. Link Previews</h2>

<p>
	You can also use Hyvor Unfold to fetch metadata from URLs. For example, you can use this to show a
	preview of a URL (called 'unfurled link').
</p>

<DemoLink />

<p>
	When you request link data (via PHP or API), we send a <code>GET</code> request to the URL and parse
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
