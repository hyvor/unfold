<?php

namespace Hyvor\Unfold\Link\MetadataParsers;

use Hyvor\Unfold\Objects\AuthorObject;
use Hyvor\Unfold\Objects\MetadataObject;

class JsonLdParser extends ParserAbstract
{
    public function add(): void
    {
        $this->parser->crawler->filterXPath('//script[@type="application/ld+json"]')->each(function ($node) {
            $json = json_decode($node->text(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return;
            }

            if (isset($json['datePublished'])) {
                $date = MetadataParser::getDateTimeFromString($json['datePublished']);
                if (!$date) {
                    return;
                }
                $this->parser->addMetadata(new MetadataObject(MetadataKeyEnum::RICH_SCHEMA_PUBLISHED_TIME, $date));
            }
            if (isset($json['dateModified'])) {
                $date = MetadataParser::getDateTimeFromString($json['dateModified']);
                if (!$date) {
                    return;
                }
                $this->parser->addMetadata(new MetadataObject(MetadataKeyEnum::RICH_SCHEMA_MODIFIED_TIME, $date));
            }
            if (isset($json['author'])) {
                foreach ($json['author'] as $author) {
                    if (isset($author['name']) || isset($author['url'])) {
                        $this->parser->addMetadata(
                            new MetadataObject(
                                MetadataKeyEnum::RICH_SCHEMA_AUTHOR,
                                new AuthorObject($author['name'], $author['url'])
                            )
                        );
                    }
                }
            }
        });
    }
}
