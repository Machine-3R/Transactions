<?php

namespace Machine3R\Transactions\TransactionService\Database\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class TransactionQuery {

	CONST TABLENAME = 'transactions';
	CONST TABLE_COLUMN_PK = 'id';
	
	/** @var Connection $connection */
	private $connection;

	/**
	 * CONSTRUCTOR
	 * @param Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * returns query to get a single transaction
	 * @param type $id
	 * @return string
	 */
	public function getById()
	{
		$qb = $this->connection->createQueryBuilder();
		return $qb
			->select('*')
			->from(self::TABLENAME)
			->where($qb->expr()->eq(self::TABLE_COLUMN_PK, '?'))
			->getSQL();
	}
	
	/**
	 * returns query to get selected transactions 
	 * @return string
	 */
	public function getSelection(array $where = null, array $order = null)
	{
		$qb = $this->connection->createQueryBuilder()
			->select('*')
			->from(self::TABLENAME);
		if ($where) {
			$qb = $this->where($qb, $where);
		}
		if ($order) {
			$column = key($order);
			$dir = array_shift($order);
			$qb->orderBy($column, $dir);
		}

		return $qb->getSQL();
	}
	
	/**
	 * return query to delete selected transactions
	 * @param array $where
	 * @return string
	 */
	public function deleteSelection(array $where = null)
	{
		$qb = $this->connection->createQueryBuilder()
			->delete(self::TABLENAME);
		if ($where) {
			$qb = $this->where($qb, $where);
		}

		return $qb->getSQL();
	}
	
	/**
	 * adds where conditions to query
	 * @param QueryBuilder $qb
	 * @param array $where
	 * @return QueryBuilder
	 */
	private function where(QueryBuilder $qb, array $where = null)
	{
		$column = key($where);
		$value = array_shift($where);
		if (is_array($value)) {
			$qb->where($qb->expr()->in($column, $value));
		}
		else {
			$qb->where($qb->expr()->eq($column, $value));
		}
		
		return $qb;
	}
}
