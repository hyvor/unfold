<?php

namespace Hyvor\Unfold\Types;

enum EmbedType: string
{
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case LINK = 'link';
    case RICH = 'rich';
}