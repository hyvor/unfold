<?php

namespace Hyvor\Unfold\Types;

enum Method: string
{
    case LINK = 'link';
    case EMBED = 'embed';
    case LINK_EMBED = 'link_embed';
}