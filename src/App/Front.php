<?php

declare(strict_types=1);

namespace Italiano\App;

use Italiano\Home\Sample;

final class Front
{
    public function __construct(private readonly string $base)
    {
    }

    public function run(): void
    {
        $router = new Router($this->base);
        $views = new Views($this->base);
        $pack = Sample::pack();
        $today = getenv('ITALIANO_TODAY') ?: '12 November 2026';

        $router->get('/', static fn (): array => [200, [
            'html' => $views->front($pack, $today),
        ]]);

        $router->get('/status', static fn (): array => [200, ['json' => [
            'ok' => true,
            'lessons' => count($pack->lessons()),
            'words' => $pack->wordTotal(),
            'references' => count($pack->references()),
        ]]]);

        [$status, $body] = $router->handle(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/',
        );

        http_response_code($status);
        if (isset($body['json'])) {
            header('Content-Type: application/json');
            echo json_encode($body['json'], JSON_UNESCAPED_SLASHES), "\n";

            return;
        }
        if (isset($body['html'])) {
            header('Content-Type: text/html; charset=utf-8');
            echo $body['html'];

            return;
        }
        header('Content-Type: text/html; charset=utf-8');
        echo $views->notFound((string) ($body['path'] ?? '/'));
    }
}
