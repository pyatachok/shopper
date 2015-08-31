<?php

namespace Application\Service\Cart;


use Application\Entity\Product;
use Application\Entity\Tag;
use Doctrine\ORM\EntityManager;

class ProductCart implements EntityManagerAwareInterface
{
	use EntityManagerAwareTrait;

	/**
	 * @var Product
	 */
	protected $product;

	/**
	 * @var Tag[]
	 */
	protected $tags;

	/**
	 * @var array
	 */
	private $allTags;

	/**
	 * @return Product
	 */
	public function getProduct()
	{
		if (empty($this->product)) {
			$this->setProduct();
		}
		return $this->product;
	}

	/**
	 * @param integer || null $id
	 *
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 * @throws \Doctrine\ORM\TransactionRequiredException
	 */
	public function setProduct ( $id = null )
	{
		if ( !empty($id) ) {
			$this->product = $this->getEntityManager()->find('Application\Entity\Product', $id);
		}

		if ( empty ( $this->product ) )
		{
			$this->product = new Product();
		}
	}

	public function setTags($tags)
	{
		$allTags = $this->getAllTags();
		$incomeTags = array_filter( array_map('trim', explode( ',', $tags)));
		$diff = array_diff($incomeTags, $allTags);
		foreach ( $diff as $tag )
		{
			$tagModel = new Tag();
			$tagModel->exchangeArray(['name' => $tag]);
			$this->getEntityManager()->persist($tagModel);
		}
		$this->getEntityManager()->flush();
		$tagsModels = $this->getEntityManager()
			->createQueryBuilder()
			->select('t')
			->from('Application\Entity\Tag', 't')
			->where('t.name IN (:names)')
			->setParameter('names', $incomeTags)
			->getQuery()
			->execute();

		if ( count ($tagsModels) > 0 ) {
			$this->getProduct()->tags->clear();
			$this->getProduct()->setTags($tagsModels);
		}
	}

	public function updateProduct($values)
	{
		$this->getProduct()->exchangeArray($values);
		$this->getProduct()->source = $this->getEntityManager()->find('Application\Entity\Source', $values['source']);
	}

	public function save()
	{
		$this->getEntityManager()->persist($this->getProduct());
		$this->getEntityManager()->flush();
	}

	/**
	 * Возвращает справочник тегов
	 * @return array
	 */
	public function getAllTags()
	{
		if ( empty($this->allTags) ) {
			$this->allTags = $this->getEntityManager()->getRepository('Application\Entity\Tag')->findAll();
			$this->allTags = array_map(function($tag){
				return $tag->name;
			}, $this->allTags);
		}

		return $this->allTags;
	}

}