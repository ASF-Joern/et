<?php

namespace AsfCronjobs\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\DependencyInjection\Container;

/**
 * Class ArticleCron
 * @package AsfCronjobs\Subscriber
 */
class ArticleCron implements SubscriberInterface
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $config;

    /**
     * @var null|Components/AsfAfterbuy
     */
    private $Afterbuy = null;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_AsfCronjobsArticleCron' => 'runArticleCron'
        ];
    }

    /**
     * QueryManagerCron constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('AsfAfterbuy');
        $this->Afterbuy = new \AsfAfterbuy\Components\Afterbuy($this->config);
    }

    /**
     * @return array
     */
    public function runArticleCron(\Shopware_Components_Cron_CronJob $job) {

        $quantity = 250;

        $this->Afterbuy->setRequest("GetShopProducts", $quantity);
        $this->Afterbuy->setFilter("Level", 0);
        $this->Afterbuy->setFilter("DateFilter", [date("Y-m-d")." 09:00:00",date("Y-m-d")." 18:00:00"]);

        $this->Afterbuy->setResponse();
        $articlesFields = $this->Afterbuy->getArticleData();

        $counter = 0;

        $mediaResource = \Shopware\Components\Api\Manager::getResource('media');

        foreach($articlesFields as $articleFields) {

            $id = Shopware()->Db()->fetchRow("SELECT articleID,changetime from s_articles_details a LEFT JOIN s_articles b ON a.articleID = b.id WHERE ordernumber = ?", $articleFields['Anr']);

            if(!empty('changetime')) {
                $parts = explode(" ",$id['changetime']);
                if($parts[0] === date("Y-m-d")) {
                    continue;
                } else {
                    $id = $id['articleID'];
                }
            }

            // If exists we update the article
            if(!empty($id)) {
                $counter++;

                if(preg_match("/Tw\/Si/i",$articleFields['FreeValue5'])) {

                    if(preg_match_all("/\d+ x \d,\d+ct./",$articleFields['FreeValue5'],$matches)) {
                        Shopware()->Db()->query("UPDATE s_articles_attributes SET attr24 = ? WHERE articleID = ?",[implode("|",$matches[0]),$id]);
                        Shopware()->Db()->query("UPDATE s_articles SET changetime = ? WHERE id = ?",[date("Y-m-d H:i:s"),$id]);
                    }

                }

                if(!empty($articleFields['ShortDescription'])) {
                    Shopware()->Db()->query("UPDATE s_articles SET description_long = ? WHERE id = ?",[$articleFields['ShortDescription'],$id]);
                    Shopware()->Db()->query("UPDATE s_articles SET changetime = ? WHERE id = ?",[date("Y-m-d H:i:s"),$id]);
                }

                if(!empty($articleFields['BuyingPrice']) && (int)$articleFields['BuyingPrice'] > 0) {
                    Shopware()->Db()->query("UPDATE s_articles_prices SET price = ? WHERE articleID = ?",[$articleFields['BuyingPrice'] / 1.19,$id]);
                    Shopware()->Db()->query("UPDATE s_articles_prices SET pseudoprice = ? WHERE articleID = ?",[$articleFields['SellingPrice'] / 1.19,$id]);
                    Shopware()->Db()->query("INSERT IGNORE INTO s_articles_categories_ro (`articleID`,`categoryID`, `parentCategoryID`) VALUES (?,?,?)", [$id,3,31]);
                    Shopware()->Db()->query("INSERT IGNORE INTO s_articles_categories_ro (`articleID`,`categoryID`, `parentCategoryID`) VALUES (?,?,?)", [$id,31,31]);
                    Shopware()->Db()->query("INSERT IGNORE INTO s_articles_categories (`articleID`,`categoryID`) VALUES (?,?)", [$id,31]);
                    Shopware()->Db()->query("UPDATE s_articles SET changetime = ? WHERE id = ?",[date("Y-m-d H:i:s"),$id]);
                } else {
                    Shopware()->Db()->query("UPDATE s_articles_prices SET pseudoprice = ? WHERE articleID = ?",[0,$id]);
                    Shopware()->Db()->query("UPDATE s_articles_prices SET price = ? WHERE articleID = ?",[$articleFields['SellingPrice'] / 1.19,$id]);
                    Shopware()->Db()->query("DELETE FROM s_articles_categories WHERE articleID = ? AND categoryID = ?",[$id,31]);
                    Shopware()->Db()->query("DELETE FROM s_articles_categories_ro WHERE articleID = ? AND categoryID = ? AND parentCategoryID = ?",[$id,31,31]);
                    Shopware()->Db()->query("DELETE FROM s_articles_categories_ro WHERE articleID = ? AND categoryID = ? AND parentCategoryID = ?",[$id,3,31]);
                    Shopware()->Db()->query("UPDATE s_articles SET changetime = ? WHERE id = ?",[date("Y-m-d H:i:s"),$id]);
                }

                continue;
            }

            $counter++;

            // We need the category for the right ring class to import the ring
            $mainCat = explode(" ", $articleFields['Name']);

            if($mainCat[0] === "Partnerringe" || $mainCat[1] === "Partnerringe" || $mainCat[2] === "Partnerringe") {
                $mainCatId = $this->config['pr_catID'];
                $Ring = new \AsfAfterbuy\Components\Partnerringe($articleFields['FreeValue8'], Shopware()->Db());
            } elseif($mainCat[0] === "Trauringe") {
                $mainCatId = $this->config['tr_catID'];
                $Ring = new \AsfAfterbuy\Components\Trauringe($articleFields['FreeValue8'], Shopware()->Db(), $this->config['tr_catID'],"");
            } elseif($mainCat[0] === "Verlobungsring") {
                $mainCatId = $this->config['vr_catID'];
                $Ring = new \AsfAfterbuy\Components\Verlobungsring($articleFields['FreeValue8'], Shopware()->Db());
            } elseif($mainCat[0] === "--Memoirenring") {
                $mainCatId = $this->config['mr_catID'];
                $Ring = new \AsfAfterbuy\Components\Memoirenring($articleFields['FreeValue8'], Shopware()->Db());
            } else {
                continue;
            }

            $Ring->loadTemplate();
            $Ring->setArticleData($articleFields);
            $Ring->dispatchMapping();

            if(!empty($Ring->getImageLink())) {
                try {
                    $mediaID = $mediaResource->create($Ring->prepareImage())->getId();
                } catch(Exception $e) {
                    die(var_dump($Ring->prepareImage()));
                }

                $media = Shopware()->Db()->fetchRow("SELECT `name`, `path` FROM s_media WHERE id = ?", $mediaID);
            }

            $Ring->createArticlesData();
            $Ring->createArticlesDetails();
            $Ring->createArticlesAttributes();
            $Ring->createArticlesPrices();
            $Ring->createCustomProductsEntry();

            $subCat = $Ring->getColor();
            $rootCatId = $this->config['root_cat'];

            $subCatId = Shopware()->Db()->fetchOne("SELECT id FROM s_categories WHERE description LIKE '%" . $subCat . "' AND parent = ?", $mainCatId);

            Shopware()->Db()->query("INSERT INTO s_articles_categories (`articleID`,`categoryID`) VALUES (?,?)", [$Ring->getId(),$subCatId]);

            Shopware()->Db()->query("INSERT INTO s_articles_categories_ro (`articleID`,`categoryID`, `parentCategoryID`) VALUES (?,?,?)", [$Ring->getId(),$subCatId,$subCatId]);
            Shopware()->Db()->query("INSERT INTO s_articles_categories_ro (`articleID`,`categoryID`, `parentCategoryID`) VALUES (?,?,?)", [$Ring->getId(),$mainCatId,$subCatId]);
            Shopware()->Db()->query("INSERT INTO s_articles_categories_ro (`articleID`,`categoryID`, `parentCategoryID`) VALUES (?,?,?)", [$Ring->getId(),$rootCatId,$subCatId]);

            if(!empty($Ring->getImageLink())) {

                Shopware()->Db()->query("INSERT INTO s_articles_img (`articleID`,`img`, `main`, `description`, `position`, `extension`, `media_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$Ring->getId(), $media['name'], 1, $media['name'], 1, "jpg", $mediaID]);

                Shopware()->Db()->query("INSERT INTO s_articles_img_attributes (`imageID`,`attribute1`, `attribute2`) 
                    VALUES (?,?,?)", [Shopware()->Db()->lastInsertId(), $Ring->getImageHash(), $Ring->getImageLink()]);

            }

        }

        return ["Artikel Import/Update","Es wurden ". $counter . " Artikel importiert/geupated"];
    }
}