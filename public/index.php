<?php
use Chat\ChatComponent;
use DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;

require dirname(__DIR__) . '/vendor/autoload.php';
$components = [
    ChatComponent::class
];
$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

$container = $builder->build();
$app = new Framework\App($container, $components);
$response = $app->run(ServerRequest::fromGlobals());

Http\Response\send($response);