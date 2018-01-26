<?php

namespace Framework;

use Interop\Container\ContainerInterface;

class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return Renderer
     */
    public function __invoke(ContainerInterface $container)
    {
        $viewPath = $container->get('views.path');
        $loader = new \Twig_Loader_Filesystem($viewPath);
        $twig = new \Twig_Environment($loader);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }
        return new Renderer($loader, $twig);
    }
}
