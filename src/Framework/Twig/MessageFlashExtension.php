<?php

namespace Framework\Twig;


use Framework\Session\FlashService;

class MessageFlashExtension  extends \Twig_Extension
{

    /**
     * @var FlashService
     */
    private $flashService;

    public function __construct(FlashService $flashService)
    {

        $this->flashService = $flashService;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('flash', [$this, 'flash'])
        ];
    }

    /**
     * @param $type
     * @return null
     */
    public function flash($type)
    {
        return $this->flashService->get($type);
    }
}