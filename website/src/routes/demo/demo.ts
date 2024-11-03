import { dev } from "$app/environment";

export function getDemoUrls() {

    if (dev) {
        const url = 'http://localhost:6001';

        return {
            url,
            iframe: url + '/iframe.php',
            unfold: url + '/unfold.php',
        }
    } else {
        const url = 'https://hyvor.com/api/public/unfold';

        return {
            url,
            iframe: url + '/iframe',
            unfold: url + '/unfold',
        }
    }

}

export async function fetchUnfold(url: string, embed = false) {

    const type = embed ? 'embed' : 'link';

    try {
        const response = await fetch(getDemoUrls().unfold + '/?type=' + type + '&url=' + encodeURIComponent(url));
        const json = await response.json();
        if (!response.ok) {
            throw new Error(json.message || 'An error occurred while fetching the data');
        } else {
            return json;
        }
    } catch (e: any) {
        throw new Error(e.message || 'An error occurred while fetching the data');
    }

}