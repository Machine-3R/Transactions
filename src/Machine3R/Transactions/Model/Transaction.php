<?php
namespace Machine3R\Transactions\Model;

use DateTime;

class Transaction
{
	/** @var DateTime $datetime */
	private $datetime;
	
	/** @var string $debtor */
	private $debtor;
	
	/** @var string $creditor */
	private $creditor;
	
	/** @var float $amount */
	private $amount;
	
	/** @var string $description */
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
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return DateTime
	 */
	public function getDatetime()
	{
		return clone $this->datetime;
	}
	
	/**
	 * @return string
	 */
	public function getDebtor()
	{
		return $this->debtor;
	}
	
	/**
	 * @return string
	 */
	public function getCreditor()
	{
		return $this->creditor;
	}
	
	/**
	 * @return float
	 */
	public function getAmount()
	{
		return $this->amount;
	}
	
	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
}
