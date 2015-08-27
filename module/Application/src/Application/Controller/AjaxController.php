<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class AjaxController extends AbstractActionController
{
	use Utils;

	public function tagsAction ()
	{
		$tags = $this->getEntityManager()->getRepository('Application\Entity\Tag')->findAll();

		$tags = array_map(function($tag){
			return $tag->name;
		}, $tags);
		return new JsonModel($tags);
	}
}