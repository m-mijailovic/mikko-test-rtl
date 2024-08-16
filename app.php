#!/usr/bin/env php
<?php

use Symfony\Component;

require __DIR__ . '/vendor/autoload.php';

class App extends Component\Console\Application
{
    public function __construct(iterable $commands)
    {
        $commands = $commands instanceof Traversable ? iterator_to_array($commands) : $commands;

        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct();
    }
}

$container = new Component\DependencyInjection\ContainerBuilder();
$loader    = new Component\DependencyInjection\Loader\YamlFileLoader($container, new Component\Config\FileLocator(__DIR__ . '/config'));

try {
    $loader->load('services.yaml');
} catch (Exception $e) {
    echo $e->getMessage();
}
$container->compile();

try {
    $app = $container->get(App::class);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
