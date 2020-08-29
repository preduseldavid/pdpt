<?php

namespace PDPT\JsonRpc\Exceptions;

use PDPT\JsonRpc\Responses\ResponseError;

class ExceptionMethod extends Exception
{
    public function __construct()
    {
        parent::__construct('Method not found', ResponseError::INVALID_METHOD);
    }
}
