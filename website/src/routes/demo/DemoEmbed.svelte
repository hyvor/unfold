<script lang="ts">
	import { onMount } from 'svelte';
	import { fetchUnfold, getDemoUrls } from './demo';
	import DemoBase from './DemoBase.svelte';
	import { Button, CodeBlock, Loader, toast, Validation } from '@hyvor/design/components';

	let value = '';
	let src: null | string = null;
	let code = '';
	let key = 1;
	let loading = false;
	let error = '';

	function load() {
		loading = true;
		error = '';
		code = '';

		fetchUnfold(value, true)
			.then((res) => {
				src = getDemoUrls().iframe + '/?url=' + encodeURIComponent(value);
				code = res.embed;
				key++;
			})
			.catch((err) => {
				error = err;
			})
			.finally(() => {
				loading = false;
			});
	}

	function copyCode() {
		navigator.clipboard.writeText(code);
		toast.success('Embed code copied to clipboard');
	}

	onMount(() => {
		window.addEventListener('message', function (event) {
			const source = event.source;
			const iframes = document.querySelectorAll('iframe');
			for (let iframe in iframes) {
				if (iframes[iframe].contentWindow === source) {
					if (event.data.type === 'unfold-iframe-resize') {
						iframes[iframe].style.height = `${event.data.height}px`;
					}
				}
			}
		});
	});
</script>

<DemoBase
	bind:value
	buttonText="Load Embed"
	placeholder="Enter URL (Youtube, Twitter, Reddit, etc.)"
	on:click={load}
>
	{#if loading}
		<Loader block padding={60} />
	{:else if error}
		<div class="error">
			<Validation type="error">{error}</Validation>
		</div>
	{:else}
		{#key key}
			{#if src}
				<div class="display">
					<iframe
						{src}
						title="Embed"
						sandbox="allow-scripts allow-same-origin allow-popups allow-presentation"
						allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"
					></iframe>
					<CodeBlock {code} />
					<Button size="small" on:click={copyCode}>Copy Embed Code</Button>
				</div>
			{/if}
		{/key}
	{/if}
</DemoBase>

<style>
	.display {
		margin-top: 20px;
	}
	iframe {
		width: 100%;
		border: none;
	}
	.error {
		padding: 20px 15px;
	}
	.display :global(pre) {
		white-space: pre-wrap !important;
	}
</style>
