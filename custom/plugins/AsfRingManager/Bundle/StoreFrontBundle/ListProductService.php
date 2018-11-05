<?php

namespace AsfRingManager\Bundle\StoreFrontBundle;

use Doctrine\DBAL\Connection;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;

class ListProductService implements ListProductServiceInterface {
    private $originalService;

    public function __construct(ListProductServiceInterface $service) {
        $this->originalService = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(array $numbers, Struct\ProductContextInterface $context)
    {
        $products = $this->originalService->getList($numbers, $context);

        $notes = $this->getNoteProducts();

        foreach ($products as $ordernumber => &$product) {

            if (in_array($product->getId(), $notes)) {
                $product->addAttribute('AsfRingManagerIsMarked', new Struct\Attribute(true));
            }

            $hash = $this->getHashedProduct($product->getId());

            if(!empty($hash)) {
                $product->addAttribute('AsfRingManagerIsHashed', new Struct\Attribute(['state' => true,'hash' => $hash]));
            }

        }


        return $products;
    }

    /**
     * {@inheritdoc}
     */
    public function get($number, Struct\ProductContextInterface $context) {

        $product = $this->originalService->get($number, $context);
        $product->addAttribute('AsfRingManagerIsMarked', new Struct\Attribute(false));
        $product->addAttribute('AsfRingManagerIsHashed', new Struct\Attribute(['state' => false,'hash' => ""]));
        return $product;

    }

    /**
     * returns ids of products who are marked from the user
     *
     * @return array
     */
    private function getNoteProducts() {

        $uniqueId = $_COOKIE['sUniqueID'];
        $userId = $_SESSION['Shopware']['sUserId'];

        if(empty($uniqueId)) {
            return [];
        }

        if(empty($userId)) {
            $userId = 0;
        }

        $notes = Shopware()->Db()->fetchPairs('
            SELECT n.ordernumber as arrayKey, n.articleID
            FROM s_order_notes n, s_articles a
            WHERE (sUniqueID = ? OR (userID != 0 AND userID = ?))
            AND a.id = n.articleID AND a.active = 1
            ORDER BY n.datum DESC',
            [$uniqueId, $userId]
        );

        return $notes;

    }

    /**
     * returns id of products who are configured from the user
     *
     * @return string
     */
    private function getHashedProduct($id) {
        return $_SESSION[$id];
    }

}
