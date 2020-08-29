<?php

namespace PDPT\JsonRpc\Tests;

use PDPT\JsonRpc\Core;
use PDPT\JsonRpc\Exceptions;

class Routes implements Core
{
    public function execute($method, $arguments)
    {
        switch ($method) {
            case 'subtract':
                return self::subtract($arguments);

            case 'implementation error':
                return self::implementationError($arguments);

            case 'invalid implementation error':
                return self::invalidImplementationError();

            case 'application error':
                return self::applicationError($arguments);

            case 'invalid application error':
                return self::invalidApplicationError();

            default:
                throw new Exceptions\ExceptionMethod();
        }
    }

    private static function subtract($arguments)
    {
        if (isset($arguments[0])) {
            @list($a, $b) = $arguments;
        } else {
            $a = @$arguments['minuend'];
            $b = @$arguments['subtrahend'];
        }
        if (!is_int($a) || !is_int($b) || (count($arguments) !== 2)) {
            throw new Exceptions\ExceptionArgument();
        }
        return $a - $b;
    }

    private static function implementationError($arguments)
    {
        throw new Exceptions\ExceptionImplementation(-32099, @$arguments[0]);
    }

    private static function invalidImplementationError()
    {
        $invalid = new \StdClass();
        throw new Exceptions\ExceptionImplementation($invalid, $invalid);
    }

    private static function applicationError($arguments)
    {
        throw new Exceptions\ExceptionApplication("Application error", 1, @$arguments[0]);
    }

    private static function invalidApplicationError()
    {
        $invalid = new \StdClass();
        throw new Exceptions\ExceptionApplication($invalid, $invalid, $invalid);
    }
}
