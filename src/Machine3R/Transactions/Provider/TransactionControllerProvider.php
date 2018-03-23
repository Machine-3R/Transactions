<?php

namespace Machine3R\Transactions\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Machine3R\Transactions\Service\Database\Query\TransactionQuery;
use Machine3R\Transactions\Service\Database\TransactionService;
use Machine3R\Transactions\Controller\TransactionController;

class TransactionControllerProvider implements ControllerProviderInterface {

	/**
	 * @inherit
	 * @param Application $app
	 * @return ControllerCollection
	 */
	public function connect(Application $app) {

		$app['service.transactions'] = function() use ($app) {
			$connection = $app['db'];
			$factory = new TransactionQuery($connection);
			return new TransactionService($connection, $factory);
		};
		$app['controller.transactions'] = function() use ($app) {
			$service = $app['service.transactions'];
			$renderer = $app['twig'];
			return new TransactionController($service, $renderer);
		};

		$controllers = $app['controllers_factory'];

		$controllers->post('/delete', 'controller.transactions:delete');
		
		$controllers->post('/{id}', 'controller.transactions:save');
		$controllers->post('/', 'controller.transactions:save');
		
		$controllers->get('/{id}', 'controller.transactions:index')->assert('id','\d+');
		$controllers->get('/', 'controller.transactions:index')->value('id','');

		return $controllers;
	}
}
