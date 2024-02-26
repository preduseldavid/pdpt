<?php

namespace JsonRpc\JsonRpc\Exceptions;

use JsonRpc\JsonRpc\Responses\ResponseError;

class ExceptionMethod extends Exception
{
    public function __construct()
    {
        parent::__construct('Method not found', ResponseError::INVALID_METHOD);
    }
}
