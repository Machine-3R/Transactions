<?php
namespace Machine3R\Transactions\TransactionService\Database;

use Doctrine\DBAL\Connection;
use Machine3R\Transactions\TransactionService\Database\Query\TransactionQuery;
use DateTime;

class TransactionService
{
	/** @var Connection $connection */
	private $connection;
	
	/** @var TransactionQuery $queries */
	private $queries;
	
	/**
	 * CONSTRUCTOR
	 * @param Connection $connection
	 * @param TransactionQuery $factory
	 */
	public function __construct(Connection $connection, TransactionQuery $factory)
	{
		$this->connection = $connection;
		$this->queries = $factory;
	}
	
	/**
	 * get a transaction by id
	 * @param int $id
	 * @return array
	 */
	public function getById($id)
	{
		return $this->connection
			->fetchAssoc(
				$this->queries->getById(),
				[
					(int)$id
				]
			);
	}
	
	/**
	 * get always a transaction
	 * @param integer $id
	 * @return array
	 */
	public function getOne($id = null)
	{
		$transaction = $this->getById($id);
		if (!$transaction) {
			$transaction = [
				'id' => null,
				'datetime' => null,
				'debtor' => null,
				'creditor' => null,
				'amount' => null,
				'description' => null
			];
		}
		return $transaction;
	}
	
	/**
	 * returns array of selected transactions
	 * @return array
	 */
	public function get(array $where = null, array $order = ['datetime'=>'ASC'])
	{
		return $this->connection
			->fetchAll(
				$this->queries->getSelection(
					$where,
					$order
				)
			);
	}
	
	/**
	 * inserts a transaction
	 * @param DateTime $datetime
	 * @param string $debtor
	 * @param string $creditor
	 * @param float $amount
	 * @param string $description
	 * @return int The number of affected rows
	 */
	public function insert(DateTime $datetime, $debtor, $creditor, $amount, $description)
	{
		return $this->connection
			->insert(
				'transactions',
				[ // set
					'id' => null,
					'datetime' => $datetime->format('Y-m-d H:i'),
					'debtor' => $debtor,
					'creditor' => $creditor,
					'amount' => $amount,
					'description' => $description
				]
			);
	}
	
	/**
	 * updates a transaction
	 * @param int $id
	 * @param DateTime $datetime
	 * @param string $debtor
	 * @param string $creditor
	 * @param float $amount
	 * @param string $description
	 * @return int The number of affected rows
	 */
	public function update($id, DateTime $datetime, $debtor, $creditor, $amount, $description)
	{
		return $this->connection
			->update(
				'transactions',
				[ // set
					'datetime' => $datetime->format('Y-m-d H:i'),
					'debtor' => $debtor,
					'creditor' => $creditor,
					'amount' => $amount,
					'description' => $description
				],
				[ // where
					'id' => (int)$id
				]
			);
	}
	
	/**
	 * deletes transactions
	 * @param array $ids
	 * @return int The number of affected rows
	 */
	public function delete(array $ids)
	{
		$where = [
			'id' => array_filter($ids, function($id) {
				return is_int((int)$id);
			})
		];
			
		return $this->connection
			->executeUpdate(
				$this->queries->deleteSelection($where)
			);
	}
}