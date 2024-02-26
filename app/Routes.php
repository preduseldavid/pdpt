<?php

namespace JsonRpc\App;

use Exception;
use JsonRpc\JsonRpc\Core;
use JsonRpc\JsonRpc\Responses\ResponseError;
use JsonRpc\JsonRpc\Exceptions\ExceptionArgument;
use JsonRpc\JsonRpc\Exceptions\ExceptionMethod;
use JsonRpc\JsonRpc\Exceptions\ExceptionApplication;
use JsonRpc\Driver\DatabaseMySQL as DBDriver;

class Routes implements Core
{
    /**
     * @throws ExceptionArgument
     * @throws ExceptionApplication
     * @throws ExceptionMethod
     */
    public function execute(string $method, array $arguments): mixed
    {
        return match ($method) {
            'getByCountryCode' => self::getByCountryCode($arguments),
            default => throw new ExceptionMethod(),
        };
    }

    /**
     * This is the implementation of getByCountryCode route - feel free to make
     * your own changes and introduce controllers to manage the APIs. But
     * because we have only one route we will not dig into that and keep all of
     * it just here.
     * @throws ExceptionApplication|ExceptionArgument
     */
    private static function getByCountryCode($arguments): bool|array|null
    {
        @list($code) = $arguments;
        if (count($arguments) !== 1 || !is_string($code) || strlen($code) !== 2) {
            throw new ExceptionArgument();
        }
        try {
            $db = new DBDriver();
            $escapedCode = $db->escapeString($code);
            return $db->runQuery("SELECT `prefix`, `name` FROM `locations_countries` WHERE `code`='$escapedCode'");
        } catch (Exception $exception) {
            throw new ExceptionApplication($exception->getMessage(), ResponseError::DATABASE_ERROR);
        }
    }
}
