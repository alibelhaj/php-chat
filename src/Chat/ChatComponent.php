<?php

namespace Chat;

use Chat\Controllers\MessagesController;
use Chat\Controllers\UsersController;
use Framework\Renderer;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

/**
 * generateur de route
 * Class ChatComponent
 * @package Chat
 */
class ChatComponent
{
    private $renderer;
    public function __construct(  Router $router,Renderer $renderer)
    {

        $this->renderer = $renderer;
        $this->renderer->addPath('chat',__DIR__.DIRECTORY_SEPARATOR.'views');
        $router->get('/login',UsersController::class,'chat.login');
        $router->post('/login' ,UsersController::class);
        $router->get("/logout",UsersController::class,'chat.logout');
        $router->get("/home",MessagesController::class,'chat.home');
        $router->post("/home",MessagesController::class);
        $router->get('/detail/{receiver:[a-z\-]+}', MessagesController::class, 'chat.detail');
        $router->post('/detail/{receiver:[a-z\-]+}', MessagesController::class);
    }


}