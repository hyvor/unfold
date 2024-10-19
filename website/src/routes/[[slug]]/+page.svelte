<script lang="ts">
	import {
		Docs,
		DocsNav as Nav,
		DocsNavCategory as NavCategory,
		DocsNavItem as NavItem,
		DocsContent as Content,
		Header
	} from '@hyvor/design/marketing';
	import { categories } from './docs';
	import { Button } from '@hyvor/design/components';
	import { IconGithub, IconBoxArrowUpRight } from '@hyvor/icons';

	export let data;
</script>

<svelte:head>
	<title>{data.name}</title>
</svelte:head>

<Header logo="/logo.svg" darkToggle={false} name="HYVOR" subName="Unfold">
	<div slot="end" class="header-end">
		<Button size="small" as="a" href="https://hyvor.com" variant="invisible">HYVOR</Button>
		<Button size="small" as="a" href="https://github.com/hyvor/unfold" target="_blank">
			<IconGithub slot="start" size={14} />
			Github
			<IconBoxArrowUpRight slot="end" size={11} />
		</Button>
	</div>
</Header>

<Docs>
	<Nav slot="nav">
		{#each categories as category}
			<NavCategory name={category.name}>
				{#each category.pages as page}
					<NavItem href={page.slug === '' ? '/' : `/${page.slug}`}>{page.name}</NavItem>
				{/each}
			</NavCategory>
		{/each}
	</Nav>
	<Content slot="content">
		<svelte:component this={data.component} />
	</Content>
</Docs>

<style>
	.header-end {
		display: inline-flex;
		align-items: center;
		gap: 6px;
	}
</style>
