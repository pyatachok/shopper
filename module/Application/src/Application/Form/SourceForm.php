<?php
namespace Application\Form;


use Zend\Form\Form;

class SourceForm extends Form
{

	public function __construct (  )
	{

		// we want to ignore the name passed
        parent::__construct('source');

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
			'name' => 'type',
			'type' => 'Select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Type',
				'value_options' => array(
					'wallet' => 'wallet',
					'debetCard' => 'debetCard',
					'creditCard' => 'creditCard',
				)
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