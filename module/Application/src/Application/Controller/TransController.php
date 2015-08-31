<?php
namespace Application\Controller;

use Application\Entity\Transaction;
use Application\Form\TransactionForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TransController extends AbstractActionController
{

	use Utils;

	public function indexAction()
	{

		return new ViewModel(array(
			'transactions' => $this->getEntityManager()->getRepository('Application\Entity\Transaction')->findBy([],['date'=> 'DESC']),
		));

	}

	public function addAction()
	{
		$form = new TransactionForm($this->getEntityManager());
		$form->get('submit')->setValue('Add');

		$request = $this->getRequest();
		if ($request->isPost()) {

			$transaction = new Transaction();
			$form->setInputFilter($transaction->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$transaction->exchangeArray($form->getData());
				$transaction->source = $this->getEntityManager()->find('Application\Entity\Source', $form->getData()['source']);
				$this->getEntityManager()->persist($transaction);
				$this->getEntityManager()->flush();

				// Redirect to list of products
				return $this->redirect()->toRoute('trans');
			}
		}

		return array('form' => $form);

	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('trans', array(
				'action' => 'add'
			));
		}

		$transaction = $this->getEntityManager()->find('Application\Entity\Transaction', $id);
		if (!$transaction) {
			return $this->redirect()->toRoute('trans', array(
				'action' => 'index'
			));
		}


		$form  = new TransactionForm($this->getEntityManager());
		$form->bind($transaction);
		$form->get('submit')->setAttribute('value', 'Редактирование');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($transaction->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$this->getEntityManager()->persist($transaction);
				$this->getEntityManager()->flush();


				// Redirect to list of albums
				return $this->redirect()->toRoute('trans');
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
			return $this->redirect()->toRoute('trans');
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');

			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$transaction = $this->getEntityManager()->find('Application\Entity\Transaction', $id);
				if ($transaction) {
					$this->getEntityManager()->remove($transaction);
					$this->getEntityManager()->flush();
				}
			}

			// Redirect to list of albums
			return $this->redirect()->toRoute('trans');
		}

		return array(
			'id'    => $id,
			'transaction' => $this->getEntityManager()->find('Application\Entity\Transaction', $id)
		);
	}


}
