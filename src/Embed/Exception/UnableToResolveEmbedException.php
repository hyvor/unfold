<?php

namespace Hyvor\Unfold\Embed\Exception;

use Hyvor\Unfold\UnfoldException;

class UnableToResolveEmbedException extends UnfoldException
{

    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('Unable to resolve embed', $code, $previous);
    }

}