<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/** @ORM\Entity
 *	@ORM\Table(name="transaction")
 */
class Transaction implements  InputFilterAwareInterface {

	protected $inputFilter;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Source")
	 * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
	 **/
	protected $source;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $amount;

	/**
	 * @ORM\Column(type="datetime" )
	 */
	protected $date;

	/**
	 * @ORM\Column(type="integer");
	 */
	protected $source_id;

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
		$this->id = isset($data['id']) ? $data['id'] : null;
		$this->source_id = $data['source'];
		$this->amount = $data['amount'];
		$this->date = isset($data['date']) ? new \DateTime($data['date']) : null;

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
				'name'     => 'date',
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

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}