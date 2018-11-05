<?php

namespace AsfRingManager\Bundle\SearchBundle;

use Enlight_Controller_Request_RequestHttp as Request;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaRequestHandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use AsfRingManager\Bundle\SearchBundle\Condition\AsfRingManagerCondition;

/**
 * {@inheritdoc}
 */
class CriteriaRequestHandler implements CriteriaRequestHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handleRequest(
        Request $request,
        Criteria $criteria,
        ShopContextInterface $context
    ) {
        if ($request->getParam('model')) {
            $criteria->addCondition(new AsfRingManagerCondition());
        }
    }
}
