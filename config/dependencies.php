<?php

use DI\ContainerBuilder;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;

use function DI\create;

$builder = new ContainerBuilder();
$dbPath = __DIR__ . '/../database.sqlite';
$builder->addDefinitions([
    PDO::class => create(PDO::class)
    ->constructor("sqlite:$dbPath"),
    Engine::class => function () {
        $templatePath = __DIR__ . '/../Views';
        return new Engine ($templatePath);
    },
]);

/** @var ContainerInterface $container */
$container = $builder->build();

return $container;