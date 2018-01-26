<?php

namespace Framework;


use GuzzleHttp\Psr7\Response;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class App
{
    /**
     * @var array
     */
    private $component = [];
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * App constructor.
     * @param string[] $components
     */
    public function __construct(ContainerInterface $container, array $components = [])
    {
        $this->container = $container;
        foreach ($components as $component) {
            $this->component[] = $this->container->get($component);
        }
    }

    public function run(ServerRequestInterface $request)
    {

        $router = $this->container->get(Router::class)->match($request);
        if (is_null($router)) {
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', $this->container->get(Router::class)->generateUri('chat.login',[]));
        }
        $params = $router->getParameters();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callBack = $router->getCallback();
        if (is_string($callBack)) {

            $callBack = $this->container->get($router->getCallback());
        }
        $response = call_user_func_array($callBack, [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('error response');
        }

    }
}