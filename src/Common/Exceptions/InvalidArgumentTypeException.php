<?php

namespace AzureOSS\Storage\Common\Exceptions;

use AzureOSS\Storage\Common\Internal\Resources;

class InvalidArgumentTypeException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $validType The valid type that should be provided by the user.
     * @param string $name      The parameter name.
     *
     * @return InvalidArgumentTypeException
     */
    public function __construct($validType, $name = null)
    {
        parent::__construct(
            sprintf(Resources::INVALID_PARAM_MSG, $name, $validType),
        );
    }
}
