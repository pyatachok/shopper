<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class ShopperController extends AbstractActionController
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

	public function indexAction()
	{
		return new ViewModel(array(
			'products' => $this->getEntityManager()->getRepository('Application\Entity\Product')->findAll(),
		));

	}

	public function addAction()
	{
	}

	public function editAction()
	{
	}

	public function deleteAction()
	{
	}
}
