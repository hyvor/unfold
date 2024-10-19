<?php

namespace Hyvor\Unfold\MetadataParsers;

enum MetadataKeyEnum
{
    case TITLE;

    case DESCRIPTION;
    case FAVICON_URL;
    case LOCALE;
    case CANONICAL_URL;

    case RICH_SCHEMA_PUBLISHED_TIME;
    case RICH_SCHEMA_MODIFIED_TIME;
    case RICH_SCHEMA_AUTHOR;

    case OG_TITLE;
    case OG_TYPE;
    case OG_IMAGE;
    case OG_URL;

    case OG_AUDIO;
    case OG_DESCRIPTION;
    case OG_LOCALE;
    case OG_SITE_NAME;
    case OG_VIDEO;

    case OG_IMAGE_URL;
    case OG_IMAGE_SECURE_URL;
    case OG_IMAGE_TYPE;


    case OG_VIDEO_SECURE_URL;
    case OG_VIDEO_TYPE;

    case OG_AUDIO_SECURE_URL;
    case OG_AUDIO_TYPE;

    case OG_ARTICLE_PUBLISHED_TIME;
    case OG_ARTICLE_MODIFIED_TIME;
    case OG_ARTICLE_AUTHOR;
    case OG_ARTICLE_TAG;

    case TWITTER_CARD;
    case TWITTER_SITE;
    case TWITTER_CREATOR;
    case TWITTER_DESCRIPTION;
    case TWITTER_TITLE;
    case TWITTER_IMAGE;
}