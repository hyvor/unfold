<script lang="ts">
	import { onMount } from 'svelte';

	let items = 1;

	function handleClick() {
		items += 1;
	}
</script>

<svelte:head>
	<script src="/child.js"></script>
</svelte:head>

<body on:click={handleClick}>
	{#each Array(items) as _, i}
		<div style="height:150px" />
	{/each}
</body>

<style>
	body {
		background-color: blue;
	}
</style>
