import type { ComponentType } from "svelte";
import Introduction from "./Introduction.svelte";
import Iframe from "./Iframe.svelte";

export const categories: Category[] = [
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
                slug: 'php',
                component: Introduction
            },
            {
                name: 'Privacy Iframe',
                slug: 'iframe',
                component: Iframe
            },
            {
                name: 'Docker Hosting',
                slug: 'docker',
                component: Introduction
            }
        ]
    }
];

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