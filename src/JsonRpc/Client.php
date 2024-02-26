<?php

namespace JsonRpc\JsonRpc;

use ErrorException;
use JsonRpc\JsonRpc\Responses\Response;
use JsonRpc\JsonRpc\Responses\ResponseError;
use JsonRpc\JsonRpc\Responses\ResponseResult;

/**
 * @link http://www.jsonrpc.org/specification JSON-RPC 2.0 Specifications
 *
 * @package JsonRpc\JsonRpc
 */
class Client
{
    /** @var string */
    const string VERSION = '2.0';

    /** @var array */
    private array $requests;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Forget any unsent queries or notifications
     */
    public function reset(): void
    {
        $this->requests = [];
    }

    /**
     * @param  int  $id
     * @param  string  $method
     * @param  array|null  $arguments  |null
     *
     * @return self
     * Returns the object handle (so you can chain method calls, if you like)
     */
    public function buildRequest(int $id, string $method, array $arguments = null): self
    {
        $request = self::getRequest($method, $arguments);
        $request['id'] = $id;

        $this->requests[] = $request;

        return $this;
    }

    /**
     * @param  string  $method
     * @param  array|null  $arguments
     *
     * @return self
     * Returns the object handle (so you can chain method calls, if you like)
     */
    public function notify(string $method, array $arguments = null): self
    {
        $request = self::getRequest($method, $arguments);

        $this->requests[] = $request;

        return $this;
    }

    /**
     * Encodes the request(s) as a valid JSON-RPC 2.0 string
     *
     * This also resets the Client, so you can use the same Client object
     * to perform more queries.
     *
     * @return string|null
     * Returns a valid JSON-RPC 2.0 message string
     * Returns null if there is nothing to encode
     */
    public function encode(): ?string
    {
        $input = $this->preEncode();

        if ($input === null) {
            return null;
        }

        return json_encode($input);
    }

    /**
     * Encodes the request(s) as a JSON-RPC 2.0 array, but does NOT perform
     * the final "json_encode" step which is necessary to turn the array
     * into a valid JSON-RPC 2.0 string. This gives you the opportunity
     * to inspect or modify the raw data, or to alter the encoding algorithm.
     *
     * When you're finished manipulating the request, you are responsible for
     * JSON-encoding the value to construct the final JSON-RPC 2.0 string.
     * @return array|null
     * Returns a JSON-RPC 2.0 request array
     * Returns null if no requests have been queued
     * @see self::encode()
     *
     * This also resets the Client, so you can use the same Client object
     * to perform more queries.
     *
     */
    public function preEncode(): ?array
    {
        $n = count($this->requests);

        if ($n === 0) {
            return null;
        }

        if ($n === 1) {
            $input = $this->requests[0];
        } else {
            $input = $this->requests;
        }

        $this->reset();

        return $input;
    }

    /**
     * Translates a JSON-RPC 2.0 server response into an array of "Response"
     * objects.
     *
     * @param  string  $json
     * String response from a JSON-RPC 2.0 server
     *
     * @return Response[]
     * Returns a zero-indexed array of "Response" objects
     *
     * @throws ErrorException
     * Throws an "ErrorException" if the response was not well-formed
     */
    public function decode(string $json): array
    {
        $input = json_decode($json, true);

        $errorCode = json_last_error();

        if ($errorCode !== 0) {
            $errorMessage = json_last_error_msg();
            $jsonException = new ErrorException($errorMessage, $errorCode);

            $valueText = self::getValueText($json);
            throw new ErrorException("Invalid JSON: {$valueText}", 0, E_ERROR, __FILE__, __LINE__, $jsonException);
        }

        return $this->postDecode($input);
    }

    /**
     * Translates a JSON-decoded server response into an array of "Response"
     * objects.
     *
     * This gives you the opportunity to use your own modified "json_decode"
     * algorithm, or to inspect or modify the server response before it is
     * processed under the JSON-RPC 2.0 specifications. This can be handy
     * if you're tweaking or extending the JSON-RPC 2.0 format.
     *
     * Before calling this method, you are responsible for JSON-decoding
     * the server response string. You should have that decoded array value
     * to use as the input here.
     * @param  mixed  $input
     * An array containing the JSON-decoded server response
     *
     * @return Response[]
     * Returns a zero-indexed array of "Response" objects
     *
     * @throws ErrorException
     * Throws an "ErrorException" if the response was not well-formed
     * @see self::decode()
     *
     */
    public function postDecode(mixed $input): array
    {
        if (!$this->getResponses($input, $responses)) {
            $valueText = self::getValueText($input);
            throw new ErrorException("Invalid JSON-RPC 2.0 response: {$valueText}");
        }

        return $responses;
    }

    private static function getRequest(string $method, array $arguments = null): array
    {
        $request = [
            'jsonrpc' => self::VERSION,
            'method' => $method
        ];

        if ($arguments !== null) {
            $request['params'] = $arguments;
        }

        return $request;
    }

    private static function getValueText($value): string
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_resource($value)) {
            $type = get_resource_type($value);
            $id = (int) $value;
            return "{$type}#{$id}";
        }

        return var_export($value, true);
    }

    private function getResponses($input, array &$responses = null): bool
    {
        if ($this->getResponse($input, $response)) {
            $responses = [$response];
            return true;
        }

        return $this->getBatchResponses($input, $responses);
    }

    private function getResponse($input, &$response): bool
    {
        return $this->getResponseResult($input, $response) ||
            $this->getResponseError($input, $response);
    }

    private function getResponseResult($input, &$response): bool
    {
        if (
            is_array($input) &&
            !array_key_exists('error', $input) &&
            $this->getVersion($input) &&
            $this->getId($input, $id) &&
            $this->getResult($input, $value)
        ) {
            $response = new ResponseResult($id, $value);
            return true;
        }

        return false;
    }

    private function getVersion(array $input): bool
    {
        return isset($input['jsonrpc']) && ($input['jsonrpc'] === self::VERSION);
    }

    private function getId(array $input, &$id): bool
    {
        if (array_key_exists('id', $input)) {
            $id = $input['id'];
            return is_null($id) || is_int($id) || is_float($id) || is_string($id);
        }

        return false;
    }

    private function getResult(array $input, &$value): bool
    {
        if (array_key_exists('result', $input)) {
            $value = $input['result'];
            return true;
        }

        return false;
    }

    private function getResponseError(mixed &$input, &$response): bool
    {
        if (
            is_array($input) &&
            !array_key_exists('result', $input) &&
            $this->getVersion($input) &&
            $this->getId($input, $id) &&
            $this->getError($input, $code, $message, $data)
        ) {
            $response = new ResponseError($id, $message, $code, $data);
            return true;
        }

        return false;
    }

    private function getError(array $input, &$code, &$message, &$data): bool
    {
        $error = $input['error'] ?? null;

        return is_array($error) &&
            $this->getErrorCode($error, $code) &&
            $this->getErrorMessage($error, $message) &&
            $this->getErrorData($error, $data);
    }

    private function getErrorCode(array $input, &$code): bool
    {
        $code = $input['code'] ?? null;

        return is_int($code);
    }

    private function getErrorMessage(array $input, &$message): bool
    {
        $message = $input['message'] ?? null;

        return is_string($message);
    }

    private function getErrorData(array $input, &$data): true
    {
        $data = $input['data'] ?? null;

        return true;
    }

    private function getBatchResponses($input, &$responses): bool
    {
        if (!is_array($input)) {
            return false;
        }

        $responses = [];
        $i = 0;

        foreach ($input as $key => $value) {
            if ($key !== $i++) {
                return false;
            }

            if (!$this->getResponse($value, $responses[])) {
                return false;
            }
        }

        return true;
    }
}
