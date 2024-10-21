<?php

namespace Hyvor\Unfold;

/**
 * UnfoldMethod::LINK:
 *  - Fetch metadata of the link.
 *  - $embed is null in Unfolded return
 *  - Other fields are set based on the metadata (as best as possible)
 * UnfoldMethod::EMBED:
 *  - Tries to get the embed HTML using parsers (see $embedMetaFallback as well)
 *  - If fails, an error is thrown
 *  - If successful, $embed is the embed HTML
 *  - All other fields of Unfolded are not set
 * UnfoldMethod::LINK_EMBED:
 *  - Fetch metadata of the link, and also tries to get the embed HTML using parsers
 *  - $embed is the embed HTML is successful, otherwise null (no error thrown on failure)
 *  - All other fields are set as in the same as UnfoldMethod::LINK
 */
enum UnfoldMethod: string
{
    case LINK = 'link';
    case EMBED = 'embed';
    case LINK_EMBED = 'link_embed';
}
