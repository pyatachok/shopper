<?php
namespace Application\Controller;

use Application\Entity\Source;
use Application\Form\SourceForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SourceController extends AbstractActionController
{

	use Utils;

	public function indexAction()
	{

		return new ViewModel(array(
			'sources' => $this->getEntityManager()->getRepository('Application\Entity\Source')->findBy([],['id'=> 'DESC']),
		));

	}

	public function addAction()
	{
		$form = new SourceForm($this->getEntityManager());
		$form->get('submit')->setValue('Add');

		$request = $this->getRequest();
		if ($request->isPost()) {

			$source = new Source();
			$form->setInputFilter($source->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$source->exchangeArray($form->getData());
				$this->getEntityManager()->persist($source);
				$this->getEntityManager()->flush();

				// Redirect to list of products
				return $this->redirect()->toRoute('source');
			}
		}

		return array('form' => $form);

	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('source', array(
				'action' => 'add'
			));
		}

		$source = $this->getEntityManager()->find('Application\Entity\Source', $id);
		if (!$source) {
			return $this->redirect()->toRoute('source', array(
				'action' => 'index'
			));
		}


		$form  = new SourceForm($this->getEntityManager());
		$form->bind($source);
		$form->get('submit')->setAttribute('value', 'Редактирование');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($source->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$this->getEntityManager()->persist($source);
				$this->getEntityManager()->flush();


				// Redirect to list of albums
				return $this->redirect()->toRoute('source');
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
			return $this->redirect()->toRoute('source');
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');

			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$source = $this->getEntityManager()->find('Application\Entity\Source', $id);
				if ($source) {
					$this->getEntityManager()->remove($source);
					$this->getEntityManager()->flush();
				}
			}

			// Redirect to list of albums
			return $this->redirect()->toRoute('source');
		}

		return array(
			'id'    => $id,
			'source' => $this->getEntityManager()->find('Application\Entity\Source', $id)
		);
	}


}
