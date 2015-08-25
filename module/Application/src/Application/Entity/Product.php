<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity
 *	@ORM\Table(name="shopper_product")
 */
class Product {


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
	 * @ORM\Column(type="string")
	 */
	protected $type;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $start;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $finish;

	/**
	 * @ORM\Column(type="datetime")
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
		$this->start = new \DateTime($data['start']);
		$this->finish = new \DateTime($data['finish']);
		$this->purchase_date = new \DateTime($data['purchase_date']);
	}



	public function has($attr)
	{
		return isset($this->$attr);
	}
}