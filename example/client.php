<?php

use JsonRpc\JsonRpc\Client;
use JsonRpc\Http\Request;

require_once __DIR__ . '/../vendor/autoload.php';

/* Build the request */
$client = new Client();
$client->buildRequest(1, 'getByCountryCode', array("RO"));
$dataEncoded = $client->encode();

/* Make the request to our localhost */
$response = Request::sendJson("http://127.0.0.1:4321", $dataEncoded);
echo "$response\n";
