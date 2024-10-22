<?php

namespace Hyvor\Unfold\Exception;

class EmbedUnableToResolveException extends UnfoldException
{
    public function __construct()
    {
        parent::__construct('Unable to resolve embed');
    }

}
