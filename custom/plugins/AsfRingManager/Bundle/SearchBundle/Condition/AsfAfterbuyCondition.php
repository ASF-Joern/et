<?php

namespace AsfRingManager\Bundle\SearchBundle\Condition;

use Shopware\Bundle\SearchBundle\ConditionInterface;

class AsfRingManagerCondition implements ConditionInterface
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
