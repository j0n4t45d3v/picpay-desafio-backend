<?php

namespace Desafio\Picpay\Lib\Web\Http;

use Desafio\Picpay\Lib\Web\Http\Status\Code;

class Response
{
    private static int $code;

    private function __construct(int|Code $code)
    {
        $value = $code;
        if($code instanceof Code){
            $value = $code->value;
        }
        self::$code = $value;
    }

    public static function status(int|Code $statusCode): static
    {
        return new static($statusCode);
    }

    public function json(array $bodyResponse): string
    {
        $response = [
            "status" => self::$code,
            "timestamp" => date("Ymd-H:i:s"),
            "data" => $bodyResponse,
        ];
        return $this->parserToJson($response);
    }

    public function errorJson(string|array $messageError): string
    {
        $responseError = [
            "status" => self::$code,
            "timestamp" => date("Ymd-H:i:s"),
            "error" => $messageError,
        ];
        return $this->parserToJson($responseError);
    }

    private function parserToJson(array $response): string
    {
        header("Content-Type: application/json");
        http_response_code(self::$code);
        return json_encode($response);
    }
}
