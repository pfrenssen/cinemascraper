<?php

require_once __DIR__ . '/vendor/autoload.php';

use CinemaScraper\Command\CinemaCity;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CinemaCity());
$application->run();
