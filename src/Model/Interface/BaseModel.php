<?php

namespace Desafio\Picpay\Model\Interface;

interface BaseModel
{
    public static function serializer(array $bodyJson): static;
}