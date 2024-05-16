<?php

namespace Desafio\Picpay\Lib\Web;

use Desafio\Picpay\Lib\Web\Http\Method;

class Route
{
    private string $uri;
    private string $method;
    private $callback;

    public function __construct(string|Method $method, string $uri, callable $callback)
    {
        $this->uri = $uri;

        $valueMethod = $method;
        $method instanceof Method && $valueMethod = $method->name;
        $this->method = $valueMethod;
        $this->callback = $callback;
    }

    public function execCallback($request): mixed
    {
        return call_user_func($this->callback, $request);
    }

}