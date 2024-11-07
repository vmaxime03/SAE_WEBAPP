<?php
declare(strict_types=1);

use Iutnc\Nrv\dispatcher\Dispatcher;
use Iutnc\Nrv\repository\NrvRepository;

require __DIR__ . '/../vendor/autoload.php';

session_start();


NrvRepository::setConfig(__DIR__ . '/../config/nrv.db.ini');

$dispatcher = new Dispatcher();

$dispatcher->run();