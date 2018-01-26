<?php

namespace Framework\Twig;


use Chat\Repository\UsersRepository;
use Framework\Session\SessionInterface;

class UserTwigExtension extends \Twig_Extension
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var UsersRepository
     */
    private $repository;

    public function __construct(SessionInterface $session, UsersRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }


    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getConnectedUser', [$this, 'getConnectedUser']),
            new \Twig_SimpleFunction('is_granted', [$this, 'is_granted']),
        ];
    }


    public function getConnectedUser()
    {
        return $this->repository->find($this->session->get('auth.user'));
    }

    public function is_granted()
    {
        if ($this->session->get('auth.user')) {
            return true;
        }
        return false;
    }
}