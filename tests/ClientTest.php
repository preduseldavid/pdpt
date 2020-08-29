<?php

namespace PDPT\JsonRpc\Tests;

use PHPUnit\Framework\TestCase;
use PDPT\JsonRpc\Client;
use PDPT\JsonRpc\Responses\ResponseResult;
use PDPT\JsonRpc\Responses\ResponseError;

class ClientTest extends TestCase
{
    public function testNotification()
    {
        $client = new Client();
        $client->notify('subtract', array(3, 2));
        $this->compare($client, '{"jsonrpc":"2.0","method":"subtract","params":[3,2]}');
    }

    public function testQuery()
    {
        $client = new Client();
        $client->buildRequest(1, 'subtract', array(3, 2));
        $this->compare($client, '{"jsonrpc":"2.0","id":1,"method":"subtract","params":[3,2]}');
    }

    public function testBatch()
    {
        $client = new Client();
        $client->buildRequest(1, 'subtract', array(3, 2));
        $client->notify('subtract', array(4, 3));
        $this->compare($client, '[{"jsonrpc":"2.0","id":1,"method":"subtract","params":[3,2]},{"jsonrpc":"2.0","method":"subtract","params":[4,3]}]');
    }

    public function testEmpty()
    {
        $client = new Client();
        $this->compare($client, null);
    }

    public function testReset()
    {
        $client = new Client();
        $client->notify('subtract', array(3, 2));
        $client->encode();
        $this->compare($client, null);
    }

    public function testDecodeResult()
    {
        $response = '{"jsonrpc":"2.0","result":2,"id":1}';
        $client = new Client();
        $actualOutput = $client->decode($response);
        $expectedOutput = [new ResponseResult(1, 2)];
        $this->assertSameValues($expectedOutput, $actualOutput);
    }

    public function testDecodeError()
    {
        $response = '{"jsonrpc":"2.0","id":1,"error":{"code":-32601,"message":"Method not found"}}';
        $client = new Client();
        $actualOutput = $client->decode($response);
        $expectedOutput = [new ResponseError(1, 'Method not found', -32601)];
        $this->assertSameValues($expectedOutput, $actualOutput);
    }

    private function assertSameValues($expected, $actual)
    {
        $expectedPhp = var_export($expected, true);
        $actualPhp = var_export($actual, true);
        $this->assertSame($expectedPhp, $actualPhp);
    }

    private function compare(Client $client, $expectedJsonOutput)
    {
        $actualJsonOutput = $client->encode();
        $expectedOutput = @json_decode($expectedJsonOutput, true);
        $actualOutput = @json_decode($actualJsonOutput, true);
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}
