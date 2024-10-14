<?php

namespace Hyvor\Unfold\Types;

enum EmbedTypeEnum: string
{
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case LINK = 'link';
    case RICH = 'rich';
}