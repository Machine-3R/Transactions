<?php
date_default_timezone_set('Europe/Amsterdam');
require '../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Machine3R\Transactions\Provider\TransactionControllerProvider;

$config = require '../config/application.php';

$app = new Application($config);
$app->register(new TwigServiceProvider(), $config['twig']);
$app->register(new DoctrineServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app->get('/', function() use ($app) {
	return $app['twig']->render('home.twig', []);
});

$app->mount('/transactions', new TransactionControllerProvider());

$app->run();
