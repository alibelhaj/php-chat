<?php

namespace Chat\Controllers;


use Chat\Entity\Users;
use Psr\Http\Message\ServerRequestInterface;

class UsersController extends AbstractController
{

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $path = $request->getUri()->getPath();
        if ($path === '/login') {
            return $this->login($request);
        } elseif ($path==='/home') {
            return $this->home($request);
        }
        elseif ($path==='/logout') {
            return $this->logout();
        }
    }

    public function login(ServerRequestInterface $request)
    {
        if ($this->session->get('auth.user')) {
           return $this->redirect('chat.home');
        }

        if ($request->getMethod() === "POST") {

            $params = $request->getParsedBody();
            $username = isset($params['username']) ? $params['username'] : '';
            $password = isset($params['password']) ? $params['password'] : '';
            if (empty($username) || empty($password)) {
                $this->flashMessage->error('Merci de saisir votre login ou mot de passe');
                return $this->redirect('chat.login');
            }
            /**
             * @return Users
             */
            $user = $this->userRepo->findByUsername($username);

            if ($user) {
                if (md5($password) === $user->password)
                {
                    $this->flashMessage->success('l\'authentification  est reussie.');
                    $this->session->set('auth.user', $user->id);
                    return $this->redirect('chat.home');
                }
                else
                {
                    $this->flashMessage->error('Probleme d\'authentification.');

                }
            } else {
                $params = $this->serialiseParams($request);
                $this->userRepo->create($params);
                $user = $this->userRepo->findByUsername($username);
                $this->flashMessage->success('l\'inscription  est reussie.');
                $this->session->set('auth.user', $user->id);
                return $this->redirect('chat.home');
            }
        }
        return $this->renderer->render('@chat/login');
    }

    public function logout()
    {
        $this->session->delete('auth.user');
        return $this->redirect('chat.login');
    }

    /**
     * @param ServerRequestInterface $request
     * @return array|null|object
     */
    private function serialiseParams(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        $date = new \DateTime();
        $params['created_at'] = $date->format('Y-m-d H:i:s');

        return $params;
    }

}