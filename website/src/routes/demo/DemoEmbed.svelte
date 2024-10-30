<script lang="ts">
	import { Button, TextInput } from '@hyvor/design/components';
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

<div class="demo">
	<div class="input">
		<TextInput
			size="small"
			bind:value
			block
			placeholder="Enter URL (Youtube, Twitter, Reddit, etc.) "
			on:keyup={onKeyUp}
		/>
		<Button on:click={load} size="small">Load Embed</Button>
	</div>

	{#key key}
		{#if src}
			<div class="display">
				<iframe
					{src}
					title="Embed"
					sandbox="allow-scripts allow-same-origin allow-popups allow-presentation"
					allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"
				></iframe>
			</div>
		{/if}
	{/key}
</div>

<style>
	.demo {
		padding: 20px 25px;
		background-color: #fbfbfb;
		border-radius: 20px;
		border: 1px solid #eee;
		margin: 20px 0;
	}
	.input {
		display: flex;
		align-items: center;
		gap: 6px;
	}
	.input :global(button) {
		flex-shrink: 0;
	}
	.display {
		margin-top: 20px;
	}
	iframe {
		width: 100%;
		border: none;
	}
</style>
