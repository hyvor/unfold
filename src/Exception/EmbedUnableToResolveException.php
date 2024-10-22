<?php

namespace Hyvor\Unfold\Exception;

class EmbedUnableToResolveException extends UnfoldException
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('Unable to resolve embed', $code, $previous);
    }

}
