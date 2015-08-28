<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Application\Form\Element;

use Doctrine\ORM\PersistentCollection;
use Zend\Form\Element;

class TextCollection extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'type' => 'text',
    );

	public function getValue()
	{
		$out = '';

		if ( $this->value instanceof PersistentCollection && !$this->value->isEmpty() ) {
			foreach ( $this->value->getValues() as $item ) {
				$out .= $item->name .',';
			}
		}

		return $out;
	}
}
