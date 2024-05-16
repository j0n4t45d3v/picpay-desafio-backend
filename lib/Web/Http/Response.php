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
        header("Content-Type: application/json");
        http_response_code(self::$code);
        return json_encode($bodyResponse);
    }
}