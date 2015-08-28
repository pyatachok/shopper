<?php

namespace Application\Service\Cart;


use Doctrine\ORM\EntityManager;

trait EntityManagerAwareTrait {

	/**
	 * @var EntityManager
	 */
	private $em;

	public function setEntityManager( EntityManager $em )
	{
		$this->em = $em;
	}

	/**
	 * @return EntityManager
	 */
	public function getEntityManager( )
	{
		return $this->em;
	}


}