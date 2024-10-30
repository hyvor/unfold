<script lang="ts">
	import { CodeBlock, Loader, Validation } from '@hyvor/design/components';
	import DemoBase from './DemoBase.svelte';

	let value = '';
	let loading = false;

	let data: any = null;
	let error = '';

	function handleClick() {
		loading = true;
		error = '';

		fetch('http://localhost:6001/link.php?url=' + encodeURIComponent(value))
			.then(async (response) => {
				const generalError = 'An error occurred while fetching the data.';
				try {
					const json = await response.json();
					if (!response.ok) {
						error = json.message || generalError;
					} else {
						data = json;
					}
				} catch (e) {
					error = generalError;
				}
			})
			.finally(() => {
				loading = false;
			});
	}

	function getHostname(url: string) {
		const a = document.createElement('a');
		a.href = url;
		return a.hostname;
	}
</script>

<DemoBase
	bind:value
	buttonText="Unfold"
	placeholder="Enter URL (https://hyvor.com)"
	on:click={handleClick}
>
	{#if loading}
		<Loader block padding={60} />
	{:else if error}
		<div class="error">
			<Validation type="error">{error}</Validation>
		</div>
	{:else if data}
		<a class="link-preview" href={data.url} target="_blank">
			<div class="left">
				<div class="title">
					{data.title || ''}
				</div>
				{#if data.description}
					<div class="description">
						{data.description || ''}
					</div>
				{/if}
				<div class="site">
					{#if data.iconUrl}
						<img src={data.iconUrl} alt={data.site} class="icon" />
					{/if}
					<span class="site-name">
						{data.siteName || (data.lastUrl ? getHostname(data.lastUrl) : '')}
					</span>
				</div>
			</div>
			{#if data.thumbnailUrl}
				<div class="right">
					<img src={data.thumbnailUrl} alt={data.title} />
				</div>
			{/if}
		</a>
		<CodeBlock code={JSON.stringify(data, null, 2)} language="json" />
	{/if}
</DemoBase>

<style>
	.link-preview {
		display: flex;
		margin: 25px 0;
		background-color: #fff;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
		border-radius: 20px;
		text-decoration: none !important;
		color: inherit !important;
		overflow: hidden;
	}
	.left {
		padding: 15px 20px;
		flex: 1;
		flex-shrink: 0;
	}
	.title {
		font-weight: 600;
	}
	.description {
		font-size: 15px;
		color: var(--text-light);
		margin-top: 6px;
	}
	.right {
		flex: 1;
		flex-shrink: 0;
		position: relative;
	}
	.right img {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		margin: 0;
		object-fit: cover;
	}
	.error {
		padding: 20px 15px;
	}
	.site {
		margin-top: 12px;
		display: flex;
		align-items: center;
		gap: 6px;
	}
	.site img.icon {
		max-width: 20px;
		max-height: 20px;
	}
	.site-name {
		font-size: 13px;
		color: var(--text-light);
	}
</style>
