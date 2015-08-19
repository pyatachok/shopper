<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class Product
{
	public $id;
	public $name;
	public $price;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->price = (!empty($data['price'])) ? $data['price'] : null;
		$this->amount = (!empty($data['amount'])) ? $data['amount'] : null;
		$this->type = (!empty($data['type'])) ? $data['type'] : null;
		$this->start = (!empty($data['start'])) ? $data['start'] : null;
		$this->finish = (!empty($data['finish'])) ? $data['finish'] : null;
		$this->purchase_date = (!empty($data['purchase_date'])) ? $data['purchase_date'] : null;
	}
}