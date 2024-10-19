import type { ComponentType } from "svelte";
import Introduction from "./Introduction.svelte";

export const categories = [
    {
        name: 'Unfold',
        pages: [
            {
                name: 'Introduction',
                slug: '',
                component: Introduction
            },  
            {
                name: 'PHP Library',
                slug: 'php'
            },
            {
                name: 'Privacy Iframe',
                slug: 'privacy-iframe'
            },
            {
                name: 'Docker Hosting',
                slug: 'docker'
            }
        ]
    }
] as Category[];

export const pages = categories.reduce((acc, category) => acc.concat(category.pages), [] as Page[]);

interface Category {
    name: string,
    pages: Page[]
}

interface Page {
    slug: string,
    name: string,
    component: ComponentType
}