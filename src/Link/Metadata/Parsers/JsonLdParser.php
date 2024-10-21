<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\MetadataParser;
use Hyvor\Unfold\Unfolded\UnfoldedAuthor;

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
                $this->parser->addMetadata(new MetadataObject(MetadataKeyType::RICH_SCHEMA_PUBLISHED_TIME, $date));
            }
            if (isset($json['dateModified'])) {
                $date = MetadataParser::getDateTimeFromString($json['dateModified']);
                if (!$date) {
                    return;
                }
                $this->parser->addMetadata(new MetadataObject(MetadataKeyType::RICH_SCHEMA_MODIFIED_TIME, $date));
            }
            if (isset($json['author'])) {
                foreach ($json['author'] as $author) {
                    if (isset($author['name']) || isset($author['url'])) {
                        $this->parser->addMetadata(
                            new MetadataObject(
                                MetadataKeyType::RICH_SCHEMA_AUTHOR,
                                new UnfoldedAuthor($author['name'], $author['url'])
                            )
                        );
                    }
                }
            }
        });
    }
}
