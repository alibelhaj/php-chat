<?php

namespace Chat\Controllers;


use Chat\Repository\MessagesRepository;
use Chat\Repository\UsersRepository;
use Framework\Renderer;
use Framework\Router;
use Framework\Session\FlashService;
use Framework\Session\SessionInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Class AbstractController
 * @package Chat\Controllers
 */
abstract class AbstractController
{
    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var UsersRepository
     */
    protected $userRepo;
    /**
     * @var MessagesRepository
     */
    protected $messageRepo;
    /**
     * @var SessionInterface
     */
    protected $session;
    /**
     * @var FlashService
     */
    protected $flashMessage;
    /**
     * @var Router
     */
    protected $router;


    public function __construct(Renderer $renderer, UsersRepository $userRepo, MessagesRepository $messageRepo, SessionInterface $session, FlashService $flashMessage, Router $router)
    {
        $this->renderer = $renderer;
        $this->userRepo = $userRepo;
        $this->messageRepo = $messageRepo;
        $this->session = $session;
        $this->flashMessage = $flashMessage;
        $this->router = $router;

    }

    public function redirect($name, $params = [])
    {
        $redirectUri = $this->router->generateUri($name, $params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', $redirectUri);
    }

    public function getCurrentUser()
    {
        $currentUser =  $this->userRepo->find($this->session->get('auth.user'));
        if ($currentUser){
            return $currentUser->username;
        }
        return null;
    }
}