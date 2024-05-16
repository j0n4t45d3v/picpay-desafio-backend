<?php

namespace Desafio\Picpay\Lib;

use ReflectionClass;

class Annotation
{
    public function getAnnotation($className, string $name)
    {
        try {
            $reflectionClass = new ReflectionClass($className);
            $docReflection = $reflectionClass->getDocComment();
            if(!$docReflection) return null;
            $regex = "/@$name\(value=\w+\)/";
            if(preg_match($regex, $docReflection, $matches)){
                return $matches;
            }
        } catch (\ReflectionException $e) {
            echo "$e";
        }
    }
}