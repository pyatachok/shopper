<?php
namespace Application\Controller;

use Application\Entity\Tag;
use Application\Form\ProductForm;
use Application\Entity\Product;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class ShopperController extends AbstractActionController
{

	use Utils;

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
		$tags = $this->getEntityManager()->getRepository('Application\Entity\Tag')->findAll();
		$tags = array_map(function($tag){
			return $tag->name;
		}, $tags);

		$request = $this->getRequest();
		if ($request->isPost()) {
			$product = new Product();
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$product->exchangeArray($form->getData());
				$incomeTags = array_filter( array_map('trim', explode( ',', $form->getData()['tags'])));
				$diff = array_diff($incomeTags, $tags);
				foreach ( $diff as $tag )
				{
					$tagModel = new Tag();
					$tagModel->exchangeArray(['name' => $tag]);
					$this->getEntityManager()->persist($tagModel);
				}
				$this->getEntityManager()->flush();
				$tagsModels = $this->getEntityManager()
					->createQueryBuilder()
					->select('t')
					->from('Application\Entity\Tag', 't')
					->where('t.name IN (:names)')
					->setParameter('names', $incomeTags)
					->getQuery()
					->execute();

				if ( count ($tagsModels) > 0 ) {
					$product->setTags($tagsModels);
				}

				$this->getEntityManager()->persist($product);
				$this->getEntityManager()->flush();

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
