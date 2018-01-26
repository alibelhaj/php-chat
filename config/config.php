<?php


use Chat\Controllers\MessagesController;
use Framework\Renderer;
use Framework\Router;
use Framework\Router\Route;
use Framework\Session\PHPSession;
use Framework\Session\SessionInterface;
use Framework\Twig\MessageFlashExtension;
use Framework\Twig\RouterTwigExtension;
use Framework\Twig\UserTwigExtension;
use Framework\TwigRendererFactory;
use Interop\Container\ContainerInterface;

return [
    'database.host' => 'localhost',
    'database.username' => 'jimmy',
    'database.name' => 'mini-chat',
    'database.password' => "test123",
    'views.path' => dirname(__DIR__) . '/layout',

    Route::class => \DI\object(),
    MessagesController::class => \DI\object(),
    Renderer::class => \DI\factory(TwigRendererFactory::class),
    'twig.extensions' => [
        DI\get(RouterTwigExtension::class),
        DI\get(MessageFlashExtension::class),
        DI\get(UserTwigExtension::class),

    ],
    SessionInterface::class =>\DI\object(PHPSession::class),
    \PDO::class => function(ContainerInterface $c){
        return new PDO('mysql:host='.$c->get('database.host').';dbname='.$c->get('database.name')
            ,$c->get('database.username'),$c->get('database.password'),
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
            );
    }

];