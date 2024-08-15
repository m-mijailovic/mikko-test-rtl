#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Console\Application;
use App\Command\ApplicationExecutionCommand;

$app = new Application();
try {
    $app->add(new ApplicationExecutionCommand());
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}