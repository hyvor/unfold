<?php

namespace Hyvor\Unfold\Embed\Parsers;

enum OEmbedType: string
{

    case PHOTO = 'photo';
    case VIDEO = 'video';
    case LINK = 'link';
    case RICH = 'rich';

}