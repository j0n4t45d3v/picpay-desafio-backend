<?php

namespace Desafio\Picpay\Lib\Web;

use Desafio\Picpay\Lib\Web\Http\Method;
use Desafio\Picpay\Lib\Web\Http\Request;
use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;
use Throwable;

class Router
{
    private string $prefix;
    private array $routesRegisters;

    public function __construct(string $prefixUrl = '')
    {
        $this->routesRegisters = [];
        $prefixUrl[0] != '/' && $prefixUrl = "/$prefixUrl";
        $this->prefix = $prefixUrl;
    }

    public function get(string $uri, callable $callback): void
    {
        $this->addRoute($uri, Method::GET, $callback);
    }

    public function post(string $uri, callable $callback): void
    {
        $this->addRoute($uri, Method::POST, $callback);
    }

    public function put(string $uri, callable $callback): void
    {
        $this->addRoute($uri, Method::PUT, $callback);
    }

    public function patch(string $uri, callable $callback): void
    {
        $this->addRoute($uri, Method::PATCH, $callback);
    }

    public function delete(string $uri, callable $callback): void
    {
        $this->addRoute($uri, Method::DELETE, $callback);
    }

    private function addRoute(string $uri, Method|string $method, callable $callback): void
    {
        error_reporting(E_ERROR | E_PARSE);
        $routeFound = $this->routesRegisters[$uri][$method->name];
        if ($routeFound != null) {
            echo "Duplicate implement route: $uri";
            exit();
        }

        $uri[0] != '/' && $uri = "/$uri";
        $uri = $this->replaceParamPatternToRegex($uri);
        $this->routesRegisters["$this->prefix$uri"][$method->name] = $callback;
    }

    private function replaceParamPatternToRegex(string $uri): string
    {
        $pattern = "#/{\w+}#";
        if(preg_match($pattern, $pattern, $matchers)) {
            $regex = "#\/{}#";
            $uri = str_replace($matchers, "/$pattern", $uri);
            echo $uri;
        }
        return $uri;
    }

    public function runRoutes(bool $removePrefixApache = false): void
    {
        error_reporting(E_ERROR | E_PARSE);

        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $requestUri = $_GET["url"] ?? $_SERVER["REQUEST_URI"];
        $requestUri = explode("?", $requestUri)[0];

//        $removePrefixApache && $requestUri = str_replace("/api", '', $requestUri);

        $methodNotAllowed = true;
        $routeNotFound = true;
        $error = [false, ''];
        $request = Request::getBody();

        if (array_key_exists($requestUri, $this->routesRegisters)) {
            $routeNotFound = false;
            $uri = $this->routesRegisters[$requestUri];
            $callback = $uri[$requestMethod];
            try {
                if ($uri != null and array_key_exists($requestMethod, $uri)) {
                    $methodNotAllowed = false;
                    echo call_user_func($callback, $request);
                }
            } catch (Throwable $error) {
                $error = [true, [
                    "message" => $error->getMessage(),
                    "stacktrace" => $error->getTraceAsString()
                ]];
            }
        }

        if ($methodNotAllowed) {
            $errorMessage = "Http Method $requestMethod Not Allowed";
            echo Response::status(Code::METHOD_NOT_ALLOWED)->errorJson($errorMessage);
        } elseif ($routeNotFound) {
            $errorMessage = "Route Not Found";
            echo Response::status(Code::NOT_FOUND)->errorJson($errorMessage);
        } elseif ($error[0]) {
            $errorMessage = $error[1];
            echo Response::status(Code::INTERNAL_SERVER_ERROR)->errorJson($errorMessage);
        }
    }
}
