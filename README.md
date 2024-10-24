# Unfold

Unfold URLs. Rich embeds via oEmbed and custom parsers. Link previews by scraping meta tags - as a PHP library or a
self-hostable Docker image.

## Supported Platforms for embeds

OEmbed:

- X (Twitter)
- TikTok
- Reddit

Custom:

- Youtube
- Facebook
- Instagram
- Github Gist

<!--
Coming soon:
- Google Maps
- Rumble
- Vimeo
 -->

## Rules for selecting platforms for embeds

- **oEmbed**: If a platform supports oEmbed, it is used.
- **Public Content**: The platform must mainly be used for public content.
    - Facebook posts are okay since the default is usually public
    - Google Drive is not okay as they are meant to be private in most cases
- **10 million active monthly users**: If a platform has less than 10 million registered active monthly users, it won't
  be supported.
- **Demand**: There should be a demand (from website owners) to add a new platform.

## Object Construction

- If the type is link or link_embed and if we can't create the embed any other way, we will try to use og tags to create
  the embed. There is a custom config to disable this fallback.
