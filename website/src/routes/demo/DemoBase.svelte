<script lang="ts">
	import { Button, TextInput } from '@hyvor/design/components';
	import { createEventDispatcher, onMount } from 'svelte';

	export let value: string;
	export let placeholder: string;
	export let buttonText: string;

	const dispatch = createEventDispatcher();

	function onKeyUp(event: KeyboardEvent) {
		if (event.key === 'Enter') {
			dispatch('click');
		}
	}
</script>

<div class="demo">
	<div class="input">
		<TextInput size="small" bind:value block {placeholder} on:keyup={onKeyUp} />
		<Button on:click size="small">{buttonText}</Button>
	</div>

	<slot />
</div>

<style>
	.demo {
		padding: 15px 15px;
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
