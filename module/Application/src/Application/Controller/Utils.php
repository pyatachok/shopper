<?php

namespace Application\Controller;


trait Utils
{

	/**
	 * @var DoctrineORMEntityManager
	 */
	protected $em;

	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
}