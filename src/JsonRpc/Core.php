<?php

namespace JsonRpc\JsonRpc;

interface Core
{
    /**
     * @param  string  $method
     * @param  array  $arguments
     * @return mixed
     */
    public function execute(string $method, array $arguments): mixed;
}
