<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/** @ORM\Entity
 *	@ORM\Table(name="product")
 */
class Product implements  InputFilterAwareInterface {

	protected $inputFilter;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $price;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $amount;

	/**
	 * @ORM\Column(type="string", columnDefinition="ENUM('service', 'stuff')")
	 */
	protected $type;

	/**
	 * @ORM\Column(type="datetime" )
	 */
	protected $start;

	/**
	 * @ORM\Column(type="datetime" )
	 */
	protected $finish;

	/**
	 * @ORM\Column(type="datetime" )
	 */
	protected $purchase_date;

	/**
	 * Magic getter to expose protected properties.
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function __get($property)
	{
		return $this->$property;
	}

	/**
	 * Magic setter to save protected properties.
	 *
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value)
	{
		$this->$property = $value;
	}

	/**
	 * Convert the object to an array.
	 *
	 * @return array
	 */
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function exchangeArray ($data = array())
	{
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->price = $data['price'];
		$this->amount = $data['amount'];
		$this->type = $data['type'];
		$this->start = isset($data['start']) ? new \DateTime($data['start']) : null;
		$this->finish = isset($data['finish']) ? new \DateTime($data['finish']) : null;
		$this->purchase_date = isset($data['purchase_date']) ? new \DateTime($data['purchase_date']) : null;
	}

	/**
	 * проверяет наличие аттрибута класса
	 * @param string $attr
	 *
	 * @return bool
	 */
	public function has($attr)
	{
		return isset($this->$attr);
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'name',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 1024,
						),
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'type',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 10,
						),
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'price',
				'required' => true,
				'filters'  => array(
					array('name' => 'NumberFormat'),
				),
				'validators' => array(
					array(
						'name'    => 'float',
					),
				),
			));


			$inputFilter->add(array(
				'name'     => 'amount',
				'required' => true,
				'filters'  => array(
					array('name' => 'NumberFormat'),
				),
				'validators' => array(
					array(
						'name'    => 'float',
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'purchase_date',
				'required' => true,
				'filters'  => array(
					array('name' => 'DateTimeSelect'),
				),
				'validators' => array(
					array(
						'name'    => 'Date',
						'options' => array(
							'format' => 'Y-m-d H:i:s'
						),
					),
				),
			));


			$inputFilter->add(array(
				'name'     => 'start',
				'required' => true,
				'filters'  => array(
					array('name' => 'DateTimeSelect'),
				),
				'validators' => array(
					array(
						'name'    => 'Date',
						'options' => array(
							'format' => 'Y-m-d H:i:s'
						),
					),
				),
			));


			$inputFilter->add(array(
				'name'     => 'finish',
				'required' => true,
				'filters'  => array(
					array('name' => 'DateTimeSelect'),
				),
				'validators' => array(
					array(
						'name'    => 'Date',
						'options' => array(
							'format' => 'Y-m-d H:i:s'
						),
					),
				),
			));


			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}