<?php

namespace PDPT\App;

use Exception;
use PDPT\JsonRpc\Core;
use PDPT\JsonRpc\Responses\ResponseError;
use PDPT\JsonRpc\Exceptions\ExceptionArgument;
use PDPT\JsonRpc\Exceptions\ExceptionMethod;
use PDPT\JsonRpc\Exceptions\ExceptionApplication;
use PDPT\Driver\DatabaseMySQL as DBDriver;

class Routes implements Core
{
    public function execute($method, $arguments)
    {
        switch ($method) {
            case 'getByCountryCode':
                return self::getByCountryCode($arguments);
            default:
                throw new ExceptionMethod();
        }
    }

    /*
     * This is the implementation of getByCountryCode route - feel free to make
     * your own changes and introduce controllers to manage the APIs. But
     * because we have only one route we will not dig into that and keep all of
     * it just here.
     */
    private static function getByCountryCode($arguments)
    {
        @list($code) = $arguments;
        if (count($arguments) !== 1 || !is_string($code) || strlen($code) !== 2) {
            throw new ExceptionArgument();
        }
        try {
            $db = new DBDriver();
            $escapedCode = $db->escapeString($code);
            $result = $db->runQuery("SELECT `prefix`, `name` FROM `locations_countries` WHERE `code`='$escapedCode'");
            return $result;
        } catch (Exception $exception) {
            throw new ExceptionApplication($exception->getMessage(), ResponseError::DATABASE_ERROR);
        }
    }
}
