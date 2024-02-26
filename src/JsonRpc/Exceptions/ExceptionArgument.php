<?php

namespace JsonRpc\JsonRpc\Exceptions;

use JsonRpc\JsonRpc\Responses\ResponseError;

class ExceptionArgument extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid params', ResponseError::INVALID_ARGUMENTS);
    }
}
