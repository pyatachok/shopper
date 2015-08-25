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
				'class' => 'form-control',
			),
			'attributes' => array(
				'min' => '2010-01-01 00:00:00',
				'max' => '2030-01-01 00:00:00',
				'step'=> '1'
			),
			'options' => array(
				'label' => 'StartDate',
				'format' => 'Y-m-d H:i:s'
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