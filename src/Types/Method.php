<?php

namespace Hyvor\Unfold\Types;

enum Method: string
{
    case EMBED = 'embed';
    case LINK = 'link';
    case LINK_EMBED = 'link_embed';
}