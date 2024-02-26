<?php

namespace JsonRpc\App;

use JsonRpc\JsonRpc\Server;
use JsonRpc\App\Routes;
use JsonRpc\Http\Request;
use JsonRpc\Http\Response;

class Kernel
{
    /** @var Routes */
    private Routes $routes;

    /** @var Server */
    private Server $server;

    public function __construct()
    {
        $this->routes = new Routes();
        $this->server = new Server($this->routes);
    }

    /**
     * Handle the incoming request through JsonRPC Server.
     *
     * @param Request $request
     * Instance of the Request class.
     *
     * @return Response|null
     * Returns a response instance with the output of the handled request
     * Returns null when no response is necessary.
     */
    public function handle(Request &$request): ?Response
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
