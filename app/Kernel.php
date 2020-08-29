<?php

namespace PDPT\App;

use PDPT\JsonRpc\Server;
use PDPT\App\Routes;
use PDPT\Http\Request;
use PDPT\Http\Response;

class Kernel
{
    /** @var Routes */
    private $routes;

    /** @var Server */
    private $server;

    public function __construct()
    {
        $this->routes = new Routes();
        $this->server = new Server($this->routes);
    }

    /**
     * Handle the incoming request through JsonRPC Server.
     *
     * @param PDPT\App\Request $request
     * Instance of the Request class.
     *
     * @return PDPT\App\Response|null
     * Returns a response instance with the output of the handled request
     * Returns null when no response is necessary.
     */
    public function handle(Request &$request)
    {
        $requestRawData = $request->getData();
        $responseRawData = $this->server->handle($requestRawData);

        if ($responseRawData) {
            $responseHeaders = [];
            if ($request->expectsJson()) {
                $responseHeaders[] = Request::HEADER_CONTENT_JSON;
            }
            return new Response($responseRawData, $responseHeaders);
        } else {
            /* No output required */
            return null;
        }
    }
}
