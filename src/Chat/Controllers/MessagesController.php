<?php

namespace Chat\Controllers;

use Psr\Http\Message\ServerRequestInterface;

class MessagesController extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $path = $request->getUri()->getPath();
        if ($path === "/home") {
            return $this->home($request);
        }

        return $this->detail($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     */
    public function home(ServerRequestInterface $request)
    {
        if (is_null($this->getCurrentUser())){
            return $this->redirect('chat.login');
        }
        if ($request->getMethod() ==='POST')
        {
            $params = $this->serialiseParams($request);
            $this->messageRepo->create($params);
            $this->flashMessage->success('Message envoye');
            return $this->redirect('chat.home');
        }
        $messages = $this->messageRepo->findAll();
        return $this->renderer->render('@chat/home',['messages' =>$messages]);
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function detail(ServerRequestInterface $request)
    {
        if (is_null($this->getCurrentUser())){
            return $this->redirect('chat.login');
        }
        $username=  $request->getAttribute('receiver');
        $user = $this->userRepo->findByUsername($username);
        $messages = $this->messageRepo->findMessageUser($this->getCurrentUser(),$username);
        if (!$user or $username === $this->getCurrentUser()){ ;
            return $this->redirect('chat.home');
        }
        if ($request->getMethod() ==='POST')
        {
            $params = $this->serialiseParams($request);
            $this->messageRepo->create($params);
            $this->flashMessage->success('Message envoye');
            return $this->redirect('chat.detail',['receiver'=>$username]);

        }
        return $this->renderer->render('@chat/detail',['user'=>$user,'messages' =>$messages]);
    }

    private function serialiseParams(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        $date = new \DateTime();
        $params['created_at'] = $date->format('Y-m-d H:i:s');
        $params['author'] = $this->getCurrentUser();
        $params['receiver'] = $request->getAttribute('receiver');
        return $params;
    }
}