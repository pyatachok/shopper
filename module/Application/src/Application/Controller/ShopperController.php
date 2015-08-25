<?php
namespace Application\Controller;

use Application\Form\ProductForm;
use Application\Entity\Product;
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
		$form = new ProductForm();
		$form->get('submit')->setValue('Add');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$product = new Product();
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$product->exchangeArray($form->getData());
				$this->getEntityManager()->persist($product);
				$this->getEntityManager()->flush();

				// Redirect to list of albums
				return $this->redirect()->toRoute('shopper');
			}
		}
		return array('form' => $form);

	}

	public function editAction()
	{
	}

	public function deleteAction()
	{
	}

	public function getProductTable()
	{

	}
}
