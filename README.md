<!--  -->
<img src="https://hyvor.com/img/logo.png" alt="Hyvor Logo" width="75" />

### Hyvor Unfold

Unfold URLs. Rich embeds via custom parsers. Link previews by scraping meta tags - as a PHP library or a self-hostable API via Docker.

[View the documentation](https://unfold.hyvor.com)

<!--
Coming soon:
- Google Maps
- Rumble
- Vimeo
 -->

## Embed platforms policy

-   **Public Content**: The platform must mainly be used for public content. For example, platforms that share private
    content like Google Drive won't be supported since most of the content is private by default.
-   **10 million active monthly users**: If a platform has less than 10 million registered active monthly users, it won't
    be supported.
-   **Ability to generate embeds**: It must be possible to generate embed codes from a URL without requiring an API call.

## Development

```bash
# Install dependencies
composer install
```

Run the website:

```bash
cd website
npm install
npm run dev
```

Run the backend (only for demos):

```bash
composer install
php -S localhost:8000
```
