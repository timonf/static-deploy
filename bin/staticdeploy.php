#!/usr/bin/env php
<?php

/*
 * command line tool for static deploy
 */

use Symfony\Component\Console\Application;
use StaticDeploy\Command\Compile as CompileCommand;

set_time_limit(0);

require_once __DIR__.'/../vendor/autoload.php';

$consoleApplication = new Application();
$consoleApplication->add(new CompileCommand(__DIR__ . '/..'));
$consoleApplication->run();
