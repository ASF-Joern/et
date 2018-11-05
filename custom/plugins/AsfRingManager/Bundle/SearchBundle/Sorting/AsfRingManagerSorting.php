<?php

namespace AsfRingManager\Bundle\SearchBundle\Sorting;

use Shopware\Bundle\SearchBundle\Sorting\Sorting;

class AsfRingManagerSorting extends Sorting implements \JsonSerializable
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'model';
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
