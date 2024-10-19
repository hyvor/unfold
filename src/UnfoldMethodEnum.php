<?php

namespace Hyvor\Unfold;

enum UnfoldMethodEnum: string
{
    case LINK = 'link';
    case EMBED = 'embed';
    case LINK_EMBED = 'link_embed';
}