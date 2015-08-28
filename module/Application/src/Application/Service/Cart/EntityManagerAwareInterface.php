<?php

namespace Application\Service\Cart;


use Doctrine\ORM\EntityManager;

interface EntityManagerAwareInterface
{
	public function setEntityManager( EntityManager $em );
	public function getEntityManager(  );
}