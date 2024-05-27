<?php

namespace Desafio\Picpay\Lib\Web\Http;

enum Method
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
    case OPTION;
}