import { error } from "@sveltejs/kit";
import { pages } from "./docs";

export async function load({ params }) {
    const slug = params.slug;
    const page = slug === undefined ? pages[0] : pages.find(p => p.slug === slug);

    if(!page) {
        error(404, 'Not found');
    }

    return {
        slug: params.slug,
        name: page.name,
        component: page.component
    }
}