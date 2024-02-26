<?php

namespace JsonRpc\Http;

/**
 * HTTP LAYER
 *
 * This class is responsible only for the writing/output of the response. It
 * takes care that the server's response gets written to the client (when
 * needed).
 */
class Response
{
    /** @var array */
    private array $headers;

    /** @var string */
    private string $data;

    /**
     * @param string $data
     * The raw data (body) that we will send to the client
     *
     * @param array $headers
     * The headers that we will send to the client
     */
    public function __construct(string &$data, array $headers = [])
    {
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * Send the response to the client
     *
     * @return void
     * No returning value is expected
     */
    public function send(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->data;
    }
}
