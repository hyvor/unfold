<script lang="ts">
	import { CodeBlock, Loader } from '@hyvor/design/components';
	import DemoBase from './DemoBase.svelte';

	let value = '';
	let loading = false;

	let data: any = null;

	function handleClick() {
		loading = true;

		fetch('http://localhost:6001/link.php?url=' + encodeURIComponent(value))
			.then((response) => response.json())
			.then((res) => {
				console.log(res);
				data = res;
			})
			.finally(() => {
				loading = false;
			});
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
	{:else if data}
		<a class="link-preview" href={data.lastUrl} target="_blank">
			<div class="left">
				<div class="title">
					{data.title || ''}
				</div>
				<div class="description">
					{data.description || ''}
				</div>
				<div class="site">
					<!--  -->
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
		margin: 20px 0;
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
	.right {
		flex: 1;
		flex-shrink: 0;
		position: relative;
	}
	.title {
		font-weight: 600;
	}
	.description {
		font-size: 15px;
		color: #666;
		margin-top: 6px;
	}
	img {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		margin: 0;
	}
</style>
