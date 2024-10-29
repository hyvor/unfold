<?php

namespace Hyvor\Unfold\Link\Metadata;

use DateTime;
use DateTimeInterface;

class MetadataDateTime extends \DateTimeImmutable implements \JsonSerializable
{
    public function jsonSerialize(): mixed
    {
        return $this->format(DateTimeInterface::ATOM);
    }
}
