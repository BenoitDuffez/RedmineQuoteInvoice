<?php

namespace AppBundle\Repository;

use AppBundle\DBAL\Types\QuoteStateType;
use Doctrine\ORM\EntityRepository;

/**
 * QuoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuoteRepository extends EntityRepository {
	public function findAll() {
		return $this->findBy([], ['dateCreation' => 'desc']);
	}

	public function createAvailableQuotesQueryBuilder() {
		return $this->createQueryBuilder('q')
					->leftJoin('q.invoices', 'i')
					->where('q.state = :state')
					->setParameter('state', QuoteStateType::ACCEPTED)
					->groupBy('q.id')
					->having('coalesce(sum(i.percentage), 0) < 100');
	}
}
