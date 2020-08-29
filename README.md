## A simple PHP implementation of [JSON-RPC protocol](https://www.jsonrpc.org/) and a database driver ([MySQL](https://www.mysql.com/)) made with these words in mind: *efficient, secure, OOP, beautiful*

### PHP Client

```php
/* Build the request */
$client = new Client();
$client->buildRequest(1, 'getByCountryCode', array("RO"));
$dataEncoded = $client->encode();

/* Make the request to our localhost */
$response = Request::sendJson("http://127.0.0.1:4321", $dataEncoded);
// response: {"jsonrpc":"2.0","id":1,"result":[{"prefix":"+40","name":"Romania"}]}
```

### JavaScript Client

```js
/* prepare the request */
const requestData = {
  jsonrpc: "2.0",
  id: 1,
  method: "getByCountryCode",
  params: ["RO"],
};

/* make the request */
const response = await fetch("http://127.0.0.1:4321", {
  method: "POST",
  mode: "cors",
  cache: "no-cache",
  credentials: "same-origin",
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
  },
  redirect: "follow",
  referrerPolicy: "no-referrer",
  body: JSON.stringify(requestData),
});

/* process the response */
const responseData = await response.json();
// responseData: {"jsonrpc":"2.0","id":1,"result":[{"prefix":"+40","name":"Romania"}]}
```

## Installation

You have to install the dependencies via [Composer](https://getcomposer.org/) from the root directory of this project:
```
composer install
```
Then make sure you have MySQL server installed on your host, import the database dump included in this project (`database` directory) and change the DB connection credentials in `src/Driver/DatabaseMySQL.php`.
Run the [PHPUnit](https://phpunit.de/) tests like this from the root directory:
```
./vendor/bin/phpunit
```


## Get started

1. Finally, you are ready to go and start the development [PHP built-in server](https://www.php.net/manual/en/features.commandline.webserver.php) (port 4321):
```
php -S 127.0.0.1:4321
```

2. Try some examples; run the examples from the root directory like below or open the `example/client.html` page in a browser.
```
php example/client.php
```
Or if you prefer you can make a http request with curl from your terminal:
```
curl -w "\n" -i -H "Accept: application/json" -H "Content-Type: application/json" --data "{\"jsonrpc\":\"2.0\",\"id\": 1,\"method\":\"getByCountryCode\",\"params\":[\"RO\"]}" http://127.0.0.1:4321
```

3. Enjoy!

###Overview
This project implements an API where you can get the country name and country phone prefix by country code. We use [JSON-RPC](https://www.jsonrpc.org/specification) protocol with a PHP server, and we also developed a simple MySQL Driver to handle the database operations. For example, for `RO` code you will get `Romania, +40` and so on. This functionality can be extended and there could also be added some other API functionalities in `app/Routes.php`. Currently there is only one route implemented, but there could be added more APIs.
