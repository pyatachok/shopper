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

				// Redirect to list of products
				return $this->redirect()->toRoute('shopper');
			}
		}
		return array('form' => $form);

	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('shopper', array(
				'action' => 'add'
			));
		}

		// Get the Album with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the index page.
		$product = $this->getEntityManager()->find('Application\Entity\Product', $id);
		if (!$product) {
			return $this->redirect()->toRoute('shopper', array(
				'action' => 'index'
			));
		}

		$form  = new ProductForm();
		$form->bind($product);
		$form->get('submit')->setAttribute('value', 'Редактирование');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$this->getEntityManager()->flush();

				// Redirect to list of albums
				return $this->redirect()->toRoute('shopper');
			}
		}

		return array(
			'id' => $id,
			'form' => $form,
		);
	}

	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('shopper');
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');

			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$product = $this->getEntityManager()->find('Application\Entity\Product', $id);
				if ($product) {
					$this->getEntityManager()->remove($product);
					$this->getEntityManager()->flush();
				}
			}

			// Redirect to list of albums
			return $this->redirect()->toRoute('shopper');
		}

		return array(
			'id'    => $id,
			'product' => $this->getEntityManager()->find('Application\Entity\Product', $id)
		);
	}


}
