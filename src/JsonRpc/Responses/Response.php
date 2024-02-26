<?php

namespace JsonRpc\JsonRpc\Responses;

abstract class Response
{
    private int $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
