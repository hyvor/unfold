<script lang="ts">
	import { Button, TextInput, Loader } from '@hyvor/design/components';
	import { onMount } from 'svelte';

	let value = '';
	let src: null | string = null;
	let key = 1;

	function load() {
		src = 'http://localhost:6001/iframe.php?url=' + encodeURIComponent(value);
		key++;
	}

	function onKeyUp(event: KeyboardEvent) {
		if (event.key === 'Enter') {
			load();
		}
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

<h2>Demo</h2>

<div class="input">
	<TextInput size="small" bind:value block placeholder="Enter URL" on:keyup={onKeyUp} />
	<Button on:click={load} size="small">Load Embed</Button>
</div>

<div class="display">
	{#key key}
		{#if src}
			<iframe
				{src}
				title="Embed"
				sandbox="allow-scripts allow-same-origin allow-popups allow-presentation"
				allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"
			></iframe>
		{/if}
	{/key}
</div>

<style>
	.input {
		display: flex;
		align-items: center;
		gap: 6px;
	}
	.input :global(button) {
		flex-shrink: 0;
	}
	.display {
		margin: 20px 0;
	}
	iframe {
		width: 100%;
		border: none;
	}
</style>
