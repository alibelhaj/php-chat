<?php

namespace Framework;


class Renderer
{
    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;
    /**
     * @var \Twig_Environment
     */
    private $twig;


    public function __construct(\Twig_Loader_Filesystem $loader, \Twig_Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    /**
     * @param string $namespace
     * @param null $path
     */
    public function addPath( $namespace,  $path = null)
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render( $view, array $params = [])
    {
        return $this->twig->render($view.'.html.twig', $params);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal( $key, $value)
    {
        $this->twig->addGlobal($key, $value);
    }
}