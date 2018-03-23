<?php
namespace Machine3R\Transactions\Model;

use DateTime;

class Transaction
{
	private $datetime;
	private $debtor;
	private $creditor;
	private $amount;
	private $description;
	
	/**
	 * CONSTRUCTOR
	 * @param DateTime $datetime
	 * @param type $debiteur
	 * @param type $crediteur
	 * @param type $amount
	 * @param type $description
	 */
	public function __construct(DateTime $datetime, $debiteur, $crediteur, $amount, $description = null) {
		$this->datetime = $datetime;
		$this->debtor = $debiteur;
		$this->creditor = $crediteur;
		$this->amount = $amount;
		$this->description = $description;
	}
}
