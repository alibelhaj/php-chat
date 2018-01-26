<?php

namespace Framework;


use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Class Router
 * @property FastRouteRouter router
 * @package Framework
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     */
    public function get($path,$callable,$name = null)
    {
        $this->router->addRoute(new ZendRoute($path,$callable,['GET'],$name));
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     */
    public function post($path,$callable,$name = null)
    {
        $this->router->addRoute(new ZendRoute($path,$callable,['POST'],$name));
    }
    /**
     * @return Route|null
     * @param ServerRequestInterface $request
     */
    public function match(ServerRequestInterface $request)
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()){
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;

    }

    /**
     * @param $name string
     * @param $params array
     * @return string
     */
    public function generateUri($name,$params)
    {
        return $this->router->generateUri($name,$params);
    }


}