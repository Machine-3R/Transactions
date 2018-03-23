<?php
return [
	'debug' => true,
	'twig' => [
		'twig.path' => __DIR__.'/../views',
	],
	'dbs.options' => [
		[
			'driver'    => 'pdo_mysql',
			'host'      => 'localhost',
			'dbname'    => 'machine3r',
			'user'      => 'root',
			'password'  => 'example',
			'charset'   => 'utf8mb4',
		],			
	],
];