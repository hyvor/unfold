<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

enum OEmbedTypeEnum: string
{
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case LINK = 'link';
    case RICH = 'rich';

}
