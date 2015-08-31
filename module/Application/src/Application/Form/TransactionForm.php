<?php
namespace Application\Form;


use Application\Service\Cart\EntityManagerAwareInterface;
use Application\Service\Cart\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class TransactionForm extends Form implements EntityManagerAwareInterface
{
	use EntityManagerAwareTrait;

	public function __construct ( EntityManager $em )
	{
		$this->setEntityManager($em);

		// we want to ignore the name passed
        parent::__construct('transaction');

		$this->setAttribute('method', 'POST');
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		$this->add(array(
			'name' => 'amount',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Amount',
			),
		));

		$this->add(array(
			'name' => 'date',
			'type' => 'DateTime',
			'attributes' => array(
				'min' => '2010-01-01 00:00:00',
				'max' => '2030-01-01 00:00:00',
				'step'=> 'any',
				'class' => 'form-control',
				'value' => new \DateTime('now'),
			),
			'options' => array(
				'label' => 'Date',
				'format' => 'Y-m-d H:i:s'
			),
		));

		$this->add(array(
			'name' => 'source',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Source',
				'object_manager' => $this->getEntityManager(),
				'target_class'   => 'Application\Entity\Source',
				'property'       => 'name',
			),
		));

		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Go',
				'id' => 'submitbutton',
				'class' => 'btn btn-default',
			),
		));
	}

}