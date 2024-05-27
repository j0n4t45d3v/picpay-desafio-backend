<?php

namespace Desafio\Picpay\Documentation;


use Desafio\Picpay\Lib\Web\Router;

class Swagger
{
    public function createDocumentationSwagger(Router $router): void
    {
        $router->get("v1/api-doc.yml", [$this,'swaggerYaml']);
        $router->get("v1/swagger-ui.css", [$this,'uiSwagger']);
        $router->get("v1/index.css", [$this,'uiSwaggerIndex']);
        $router->get("v1/swagger-ui-bundle.js", [$this,'uiSwaggerBundler']);
        $router->get("v1/swagger-ui-standalone-preset.js", [$this,'uiSwaggerPreset']);
        $router->get("v1/swagger-initializer.js", [$this,'uiSwaggerInitializer']);
        $router->get("v1/favicon-32x32.png", [$this,'uiSwaggerFavicon32']);
        $router->get("v1/favicon-16x16.png", [$this,'uiSwaggerFavicon16']);
        $router->get("v1/documentation", [$this,'documentationSwagger']);
    }

    public function swaggerYaml(): void
    {
        $file = SWAGGER_DIR ."/swagger.yml";
        header('Content-Type: ' . mime_content_type($file));
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        readfile($file);
    }

    public function uiSwagger(): void
    {
        $file = SWAGGER_DIR ."/static/swagger-ui.css";
        $this->serverStaticProvider($file, 'text/css');
    }

    public function uiSwaggerIndex(): void
    {
        $file = SWAGGER_DIR ."/static/index.css";
        $this->serverStaticProvider($file, 'text/css');
    }

    public function uiSwaggerBundler(): void
    {
        $file = SWAGGER_DIR ."/static/swagger-ui-bundle.js";
        $this->serverStaticProvider($file, 'application/javascript');
    }

    public function uiSwaggerPreset(): void
    {
        $file = SWAGGER_DIR ."/static/swagger-ui-standalone-preset.js";
        $this->serverStaticProvider($file, 'application/javascript');
    }

    public function uiSwaggerInitializer(): void
    {
        $file = SWAGGER_DIR ."/static/swagger-initializer.js";
        $this->serverStaticProvider($file, 'application/javascript');
    }

    public function uiSwaggerFavicon16(): void
    {
        $file = SWAGGER_DIR ."/static/favicon-16x16.png";
        $this->serverStaticProvider($file, 'image/png');
    }

    public function uiSwaggerFavicon32(): void
    {
        $file = "/static/favicon-32x32.png";
        $this->serverStaticProvider($file, 'image/png');
    }

    public function documentationSwagger(): void
    {
        $file = SWAGGER_DIR ."/static/index.html";
        $this->serverStaticProvider($file, 'text/html');
    }

    private function serverStaticProvider($file_path, $content_type): void
    {
        header('Content-Type: ' . $content_type);
        readfile($file_path);
    }
}
