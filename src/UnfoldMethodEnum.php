<?php

namespace Hyvor\Unfold;

/**
 * UnfoldMethodEnum::LINK:
 *  - Fetch metadata of the link.
 *  - $embed is null in UnfoldedObject return
 *  - Other fields are set based on the metadata (as best as possible)
 * UnfoldMethodEnum::EMBED:
 *  - Tries to get the embed HTML using parsers (see $embedMetaFallback as well)
 *  - If fails, an error is thrown
 *  - If successful, $embed is the embed HTML
 *  - All other fields of UnfoldedObject are not set
 * UnfoldMethodEnum::LINK_EMBED:
 *  - Fetch metadata of the link, and also tries to get the embed HTML using parsers
 *  - $embed is the embed HTML is successful, otherwise null (no error thrown on failure)
 *  - All other fields are set as in the same as UnfoldMethodEnum::LINK
 */
enum UnfoldMethodEnum: string
{
    case LINK = 'link';
    case EMBED = 'embed';
    case LINK_EMBED = 'link_embed';
}
