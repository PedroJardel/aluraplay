<?php

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

use function DI\create;

$builder = new ContainerBuilder();
$dbPath = __DIR__ . '/../database.sqlite';
$builder->addDefinitions([
    PDO::class => create(PDO::class)
    ->constructor("sqlite:$dbPath"),
]);

/** @var ContainerInterface $container */
$container = $builder->build();

return $container;