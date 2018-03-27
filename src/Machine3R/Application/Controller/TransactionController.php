<?php

namespace Machine3R\Application\Controller;

use Silex\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Machine3R\Transactions\TransactionService\Database\TransactionService;
use Twig_Environment;
use DateTime;

class TransactionController extends Controller
{
	/* @var Connection $service */
	private $service;
	
	/* @var Twig_Environment $renderer */
	private $renderer;
	
	/**
	 * CONSTRUCTOR
	 * @param TransactionService $service
	 * @param Twig_Environment $renderer
	 */
	public function __construct(TransactionService $service, Twig_Environment $renderer) {
		$this->service = $service;
		$this->renderer = $renderer;
	}
	
	/**
	 * lists overview
	 * @param Request $request
	 * @return string
	 */
	public function index(Request $request)
	{	
		$id = $request->get('id', null);
	
		return $this->renderer->render(
			'transactions/index.twig', 
			[
				'transaction' => $this->service->getOne($id),
				'transactions' => $this->service->get(),
			]
		);
	}

	/**
	 * saves transaction
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function save(Request $request)
	{
		$id = $request->get('id', null);
		$date = $request->get('date');
		$time = array_filter(explode(':', $request->get('time', null)));
		$debtor = $request->get('debtor');
		$creditor = $request->get('creditor');
		$amount = $request->get('amount');
		$description = $request->get('description', null);

		$moment = new DateTime($date);
		if (is_array($time) && count($time) > 0) {
			$moment->setTime($time[0], $time[1]);
		}

		if (is_numeric($id) && $id > 0) {
			$this->service->update($id, $moment, $debtor, $creditor, $amount, $description);
		} else {
			$this->service->insert($moment, $debtor, $creditor, $amount, $description);
		}

		return new RedirectResponse('/transactions');
	}

	/**
	 * delete selected transactions
	 * @param Request $request
	 * @return RedirectResponse|string
	 */
	public function delete(Request $request) 
	{
		$ids = $request->get('delete', []);
		$confirmation = $request->get('confirmation', 0);
		
		if ($confirmation) {
			print_r($ids);
			$this->service->delete($ids);
			return new RedirectResponse('/transactions');
		}

		return $this->renderer->render(
			'transactions/delete.twig', 
			[
				'transactions' => $this->service->get(
					[ // where
						'id' => $ids
					]
				)
			]
		);
	}
}
