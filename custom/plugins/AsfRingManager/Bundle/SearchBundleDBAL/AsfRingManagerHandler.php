<?php

namespace AsfRingManager\Bundle\SearchBundleDBAL;

use Shopware\Bundle\SearchBundle\ConditionInterface;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\FacetInterface;
use Shopware\Bundle\SearchBundle\FacetResult\BooleanFacetResult;
use Shopware\Bundle\SearchBundle\SortingInterface;
use Shopware\Bundle\SearchBundleDBAL\ConditionHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\FacetHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\PartialFacetHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilder;
use Shopware\Bundle\SearchBundleDBAL\SortingHandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use AsfRingManager\Bundle\SearchBundle\Condition\AsfRingManagerCondition;
use AsfRingManager\Bundle\SearchBundle\Facet\AsfRingManagerFacet;
use AsfRingManager\Bundle\SearchBundle\Sorting\AsfRingManagerSorting;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AsfRingManagerHandler implements SortingHandlerInterface, FacetHandlerInterface, PartialFacetHandlerInterface, ConditionHandlerInterface
{
    const ASF_AFTERBUY_TABLE_JOINED = 's_articles_attributes';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsSorting(SortingInterface $sorting)
    {
        return $sorting instanceof AsfRingManagerSorting;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsFacet(FacetInterface $facet)
    {
        return $facet instanceof AsfRingManagerFacet;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsCondition(ConditionInterface $condition)
    {
        return $condition instanceof AsfRingManagerCondition;
    }

    /**
     * {@inheritdoc}
     */
    public function generateSorting(
        SortingInterface $sorting,
        QueryBuilder $query,
        ShopContextInterface $context
    ) {
        $this->addJoin($query);

        /* @var AsfRingManagerSorting $sorting */
        $query->addOrderBy('s_articles_attributes.articleID IS NOT NULL', $sorting->getDirection());
    }

    /**
     * {@inheritdoc}
     */
    public function generateFacet(
        FacetInterface $facet,
        Criteria $criteria,
        Struct\ShopContextInterface $context
    ) {
        $reverted = clone $criteria;
        $reverted->resetConditions();
        $reverted->resetSorting();

        return $this->generatePartialFacet($facet, $reverted, $criteria, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function generatePartialFacet(
        FacetInterface $facet,
        Criteria $reverted,
        Criteria $criteria,
        ShopContextInterface $context
    ) {
        /** @var \Shopware\Bundle\SearchBundleDBAL\QueryBuilderFactoryInterface $factory */
        $factory = $this->container->get('shopware_searchdbal.dbal_query_builder_factory');

        $query = $factory->createQuery($reverted, $context);

        $query->select(['product.id']);
        $query->setMaxResults(1);

        $this->addJoin($query);

        $query->andWhere('s_articles_attributes.articleID IS NOT NULL');

        /** @var $statement \PDOStatement */
        $statement = $query->execute();

        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            return false;
        }

        /** @var CustomAsfRingManagerFacet $facet */
        $label = $facet->getLabel();

        if ($label === null) {
            $label = $this->container->get('snippets')
                ->getNamespace('frontend/listing/index')
                ->get('FacetName');
        }

        return new BooleanFacetResult(
            $facet->getName(),
            'model',
            $criteria->hasCondition($facet->getName()),
            $label
        );
    }

    /**
     * {@inheritdoc}
     */
    public function generateCondition(
        ConditionInterface $condition,
        QueryBuilder $query,
        ShopContextInterface $context
    ) {
        if ($query->hasState(self::ASF_AFTERBUY_TABLE_JOINED)) {
            return;
        }
        $query->addState(self::ASF_AFTERBUY_TABLE_JOINED);

        $query->select(['product.id']);
        $query->innerJoin(
            'product',
            's_articles_attributes',
            'asf_attributes',
            'asf_attributes.articleID = product.id'
        );


        $material = empty($_GET['material']) ? "Weißgold" : $_GET['material'];

        if($material == "Platin") {
            $alloy = "600er";
        } elseif ($material == "Palladium") {
            $alloy = "585er";
        } else {
            $alloy = "333er";
        }

        $query->andWhere('asf_attributes.attr7 = "'.$alloy.'"');
        $query->andWhere('asf_attributes.attr13 = "'.$material.'"');
        $query->andWhere('(asf_attributes.attr24 = 1)');


    }

    /**
     * @param QueryBuilder $query
     */
    private function addJoin(QueryBuilder $query)
    {
        $query->leftJoin(
            'product',
            's_articles_attributes',
            'asf_attributes',
            'asf_attributes.articleID = product.id'
        );
    }
}
