<?php

namespace PDPT\JsonRpc\Exceptions;

use PDPT\JsonRpc\Responses\ResponseError;

class ExceptionArgument extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid params', ResponseError::INVALID_ARGUMENTS);
    }
}
