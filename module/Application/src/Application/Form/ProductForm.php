<?php
namespace Application\Form;


use Zend\Form\Form;

class ProductForm extends Form
{
	public function __construct ( $name = null )
	{
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
					1 => 'service',
					2 => 'stuff',
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
				'class' => 'form-control',
//				'value' => new \DateTime('now'),
			),
			'options' => array(
				'label' => 'Start Date',
				'format' => 'Y-m-d H:i:s'
			),
		));

		$this->add(array(
			'name' => 'finish',
			'type' => 'DateTimeSelect',
			'attributes' => array(
				'min' => '2010-01-01 00:00:00',
				'max' => '2030-01-01 00:00:00',
				'step'=> 'any',
				'class' => 'form-control',
				'value' => new \DateTime('tomorrow'),
			),
			'options' => array(
				'label' => 'Finish Date',
				'format' => 'Y-m-d H:i'
			),
		));

		$this->add(array(
			'name' => 'purchase_date',
			'type' => 'DateTimeSelect',
			'attributes' => array(
				'min' => '2010-01-01 00:00:00',
				'max' => '2030-01-01 00:00:00',
				'step'=> 'any',
				'class' => 'form-control',
				'value' => new \DateTime('now'),
			),
			'options' => array(
				'label' => 'Purchase Date',
				'format' => 'Y-m-d H:i:s'
			),
		));

		$this->add(array(
			'name' => 'tags',
			'type' => 'Text',
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