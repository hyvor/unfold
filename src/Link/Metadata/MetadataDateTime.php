<?php

namespace Hyvor\Unfold\Link\Metadata;

class MetadataDateTime extends \DateTimeImmutable implements \JsonSerializable
{
    public function jsonSerialize(): mixed
    {
        return $this->format(\DateTime::ATOM);
    }
}
