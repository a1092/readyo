<?php

namespace Efrei\Readyo\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

	public function search($filter) {
		
		$qb = $this->createQueryBuilder('user');

		if(array_key_exists("email", $filter) && !empty($filter["email"]))
			$qb->andWhere('user.email = :email')
				->setParameter('email', $filter["email"])
			;

		if(array_key_exists("username", $filter) && !empty($filter["username"])) 
			$qb->andWhere('user.username = :username')
				->setParameter('username', $filter["username"])
			;

		if(array_key_exists("lastname", $filter) && !empty($filter["lastname"])) 
			$qb->andWhere('user.lastname = :lastname')
				->setParameter('lastname', $filter["lastname"])
			;

		if(array_key_exists("groups", $filter) && !empty($filter["groups"])) 
			$qb->andWhere('user.roles LIKE :roles')
				->setParameter('roles', '%' . $filter["groups"] . '%')
			;


		if(array_key_exists("valid", $filter) && !empty($filter["valid"])) {
			
			if($filter["valid"] == "true") {
				$qb->andWhere('user.confirmationToken is null')
					->andWhere('user.locked = 0')
				;
			}
			else {
				$qb->andWhere('user.confirmationToken is not null')
				;
			}
		}



		$qb
			->orderBy('user.lastname', 'ASC')
			->addOrderBy('user.firstname', 'ASC')
		//	->setFirstResult( $offset )
   		//	->setMaxResults( $limit );
		;


		return $qb
			->getQuery()
			->getResult()
		;
	}


}