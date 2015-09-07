<?php
namespace Application\Form;


use Application\Service\Cart\EntityManagerAwareInterface;
use Application\Service\Cart\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Form\Exception\InvalidArgumentException;
use Zend\Form\Form;

class ProductForm extends Form implements EntityManagerAwareInterface
{
	use EntityManagerAwareTrait;

	public function __construct ( EntityManager $em )
	{
		$this->setEntityManager($em);

		// we want to ignore the name passed
        parent::__construct('product');

		$this->setAttribute('method', 'POST');
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		$this->add(array(
			'name' => 'name',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Name',
			),
		));
		$this->add(array(
			'name' => 'price',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Price',
			),
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
			'name' => 'type',
			'type' => 'Select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Type',
				'value_options' => array(
					'service' => 'service',
					'stuff' => 'stuff',
				)
			),
		));

		$this->add(array(
			'name' => 'start',
			'type' => 'DateTime',
			'attributes' => array(
				'min' => '2010-01-01 00:00:00',
				'max' => '2030-01-01 00:00:00',
				'step'=> 'any',
				'class' => 'form-control datetimepicker',
				'value' => new \DateTime('now'),
			),
			'options' => array(
				'label' => 'Start Date',
				'format' => 'Y-m-d H:i'
			),
		));

		$this->add(array(
			'name' => 'finish',
			'type' => 'DateTime',
			'attributes' => array(
				'min' => '2010-01-01 00:00:00',
				'max' => '2030-01-01 00:00:00',
				'step'=> 'any',
				'class' => 'form-control datetimepicker',
				'value' => new \DateTime('now'),
			),
			'options' => array(
				'label' => 'Finish Date',
				'format' => 'Y-m-d H:i'
			),
		));



//		$this->add(array(
//			'name' => 'finish',
//			'type' => 'DateTime',
//			'attributes' => array(
//				'min' => '2010-01-01 00:00:00',
//				'max' => '2030-01-01 00:00:00',
//				'step'=> 'any',
//				'class' => 'form-control datetimepicker',
//				'value' => new \DateTime('tomorrow'),
//			),
//			'options' => array(
//				'label' => 'Finish Date',
//				'format' => 'Y-m-d H:i'
//			),
//		));

		$this->add(array(
			'name' => 'purchase_date',
			'type' => 'DateTime',
			'attributes' => array(
				'min' => '2010-01-01 00:00',
				'max' => '2030-01-01 00:00',
				'step'=> 'any',
				'class' => 'form-control datetimepicker',
				'value' => new \DateTime('now'),
			),
			'options' => array(
				'label' => 'Purchase Date',
				'format' => 'Y-m-d H:i'
			),
		));

		$this->add(array(
			'name' => 'tags',
			'type' => 'Application\Form\Element\TextCollection',
			'attributes' => array(
				'class' => 'form-control js-typeahead',
				'data-provide' => 'typeahead',
				'autocomplete' => 'off'
			),
			'options' => array(
				'label' => 'Tags',
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