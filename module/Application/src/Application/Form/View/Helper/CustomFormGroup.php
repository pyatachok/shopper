<?php

namespace Application\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormLabel;
use Zend\Form\Exception;

class CustomFormGroup extends  FormLabel
{

	/**
	 * Generate an opening label tag
	 *
	 * @param  null|array|ElementInterface $attributesOrElement
	 * @throws Exception\InvalidArgumentException
	 * @throws Exception\DomainException
	 * @return string
	 */
	public function openTag($attributesOrElement = null)
	{
		if (null === $attributesOrElement) {
			return '<div class="row"><div class="form-group col-lg-12">';
		}

		if (is_array($attributesOrElement)) {
			$attributes = $this->createAttributesString($attributesOrElement);
			return sprintf('<label %s>', $attributes);
		}

		if (!$attributesOrElement instanceof ElementInterface) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects an array or Zend\Form\ElementInterface instance; received "%s"',
				__METHOD__,
				(is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
			));
		}

		$id = $this->getId($attributesOrElement);
		if (null === $id) {
			throw new Exception\DomainException(sprintf(
				'%s expects the Element provided to have either a name or an id present; neither found',
				__METHOD__
			));
		}

		$labelAttributes = array();
		if ($attributesOrElement instanceof LabelAwareInterface) {
			$labelAttributes = $attributesOrElement->getLabelAttributes();
		}

		$attributes = array('for' => $id);

		if (!empty($labelAttributes)) {
			$attributes = array_merge($labelAttributes, $attributes);
		}

		$attributes = $this->createAttributesString($attributes);
		return sprintf('<div %s>', $attributes);
	}

	/**
	 * Return a closing label tag
	 *
	 * @return string
	 */
	public function closeTag()
	{
		return '</div></div>';
	}
}