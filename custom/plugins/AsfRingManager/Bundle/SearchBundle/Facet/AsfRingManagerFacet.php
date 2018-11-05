<?php

namespace AsfRingManager\Bundle\SearchBundle\Facet;

use Shopware\Bundle\SearchBundle\FacetInterface;

/**
 * {@inheritdoc}
 */
class AsfRingManagerFacet implements FacetInterface
{
    /**
     * @var string
     */
    private $label;

    /**
     * @param string|null $label
     */
    public function __construct($label = null)
    {
        $this->label = $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'model';
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
