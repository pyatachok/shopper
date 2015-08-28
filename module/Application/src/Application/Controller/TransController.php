<?php
namespace Application\Controller;

use Application\Form\ProductForm;
use Application\Service\Cart\ProductCart;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TransController extends AbstractActionController
{

	use Utils;

	public function indexAction()
	{

		return new ViewModel(array(
			'trans' => $this->getEntityManager()->getRepository('Application\Entity\Transaction')->findBy([],['date'=> 'DESC']),
		));

	}

	public function addAction()
	{
		$form = new ProductForm();
		$form->get('submit')->setValue('Add');

		/**
		 * @var $productCart ProductCart
		 */
		$productCart = $this->getServiceLocator()->get('productService');

		$tags = $productCart->getAllTags();

		$request = $this->getRequest();
		if ($request->isPost()) {

			$product = $productCart->getProduct();
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$productCart->updateProduct($form->getData());
				$productCart->setTags($form->getData()['tags']);
				$productCart->save();

				// Redirect to list of products
				return $this->redirect()->toRoute('shopper');
			}
		}

		return array('form' => $form, 'tags' => json_encode($tags));

	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('shopper', array(
				'action' => 'add'
			));
		}

		/**
		 * @var $productCart ProductCart
		 */
		$productCart = $this->getServiceLocator()->get('productService');

		$productCart->setProduct($id);
		$product = $productCart->getProduct();
		if (!$product) {
			return $this->redirect()->toRoute('shopper', array(
				'action' => 'index'
			));
		}

		$tags = $productCart->getAllTags();

		$form  = new ProductForm();
		$form->bind($product);
		$form->get('submit')->setAttribute('value', 'Редактирование');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$productCart->setTags($request->getPost('tags'));
				$productCart->save();

				// Redirect to list of albums
				return $this->redirect()->toRoute('shopper');
			}
		}

		return array(
			'id' => $id,
			'form' => $form,
			'tags' => json_encode($tags)
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
					$product->tags->clear();
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
