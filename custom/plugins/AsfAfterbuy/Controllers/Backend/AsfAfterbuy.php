<?php

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_AsfAfterbuy extends Enlight_Controller_Action implements CSRFWhitelistAware
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var null|Components/AsfAfterbuy
     */
    private $Afterbuy = null;

    /**
     * Sets the config and afterbuy component to handle xml requests
     */
    public function init() {
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('AsfAfterbuy');
        $this->Afterbuy = new AsfAfterbuy\Components\Afterbuy($this->config);
    }

    /**
     * Is always called before the requested controller action is called
     */
    public function preDispatch() {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    /**
     * Is always called after the requested controller action was called
     */
    public function postDispatch() {

        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign([ 'csrfToken' => $csrfToken ]);


        $this->Afterbuy->setRequest("GetAfterbuyTime");
        $this->Afterbuy->setResponse();

        $this->View()->assign("response", $this->Afterbuy->getResponse());

    }

    /**
     * Is called to display the import window
     */
    public function importAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        $row = 0;
        $collection = [];

        $i = 0;
        if (($handle = fopen(realpath(__DIR__ . "/../../../../../csv/Afterbuy-API.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                if($row === 0) {
                    $row++;
                    continue;
                }

                $collection[$data[1]][] = $data[2];
                $i++;

            }

        }

        fclose($handle);

        $this->View()->assign("articles", $collection);
        $this->View()->assign("articleQuantity", $i);

    }

    public function exportAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

    }

    /**
     * Import 250 articles which has level 0
     */
    public function addArticlesAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        Shopware()->Front()->Plugins()->ViewRenderer()->setNoRender();

        $productID = $this->Request()->getParam("productID", null);
        $quantity = $this->Request()->getParam("quantity", 250);
        $typeOf = $this->Request()->getParam("typeOf", null);
        $ringName = $this->Request()->getParam("ringName", null);

        $this->Afterbuy->setRequest("GetShopProducts", $quantity);
        $this->Afterbuy->setFilter("Level", 0);

        if(!empty($productID)) {
            $this->Afterbuy->setFilter("RangeID", [($productID), '']);
        }

        $this->Afterbuy->setResponse();
        $articlesFields = $this->Afterbuy->getArticleData();

        $counter = 0;

        $mediaResource = \Shopware\Components\Api\Manager::getResource('media');

        foreach($articlesFields as $articleFields) {

            $id = Shopware()->Db()->fetchOne("SELECT articleID from s_articles_details WHERE ordernumber = ?", $articleFields['Anr']);

            // If exists we update the article
            if(!empty($id) && empty($typeOf)) {
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

            // If we want import all use an empty string
            if($articleFields['FreeValue8'] !== $ringName && !empty($ringName)) {
                continue;
            }

            $counter++;
            // We need the category for the right ring class to import the ring
            $mainCat = explode(" ", $articleFields['Name']);

            if($mainCat[0] === "Partnerringe" || $mainCat[1] === "Partnerringe" || $mainCat[2] === "Partnerringe") {
                $mainCatId = $this->config['pr_catID'];
                $Ring = new AsfAfterbuy\Components\Partnerringe($articleFields['FreeValue8'], Shopware()->Db());
            } elseif($mainCat[0] === "Trauringe") {
                $mainCatId = $this->config['tr_catID'];
                $Ring = new AsfAfterbuy\Components\Trauringe($articleFields['FreeValue8'], Shopware()->Db(), $this->config['tr_catID'],$this->get('pluginlogger'));
            } elseif($mainCat[0] === "Verlobungsring") {
                $mainCatId = $this->config['vr_catID'];
                $Ring = new AsfAfterbuy\Components\Verlobungsring($articleFields['FreeValue8'], Shopware()->Db());
            } elseif($mainCat[0] === "Memoirering") {
                $mainCatId = $this->config['ma_catID'];
                $Ring = new AsfAfterbuy\Components\Memoirering($articleFields['FreeValue8'], Shopware()->Db(),$this->config['ma_catID']);
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

            if(empty($typeOf)) {

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

                //$Ring->createFilters();

            } else {

                $Ring->updateArticlesData();
                $Ring->updateArticlesDetails();
                $Ring->updateArticlesAttributes();
                $Ring->updateArticlesPrices();
                $Ring->updateCustomProductsEntry();

                if(!empty($Ring->getImageLink())) {

                    Shopware()->Db()->query("INSERT INTO s_articles_img (`articleID`,`img`, `main`, `description`, `position`, `extension`, `media_id`) 
                VALUES (?,?,?,?,?,?,?)", [$Ring->getId(), $media['name'], 1, $media['name'], 1, "jpg", $mediaID]);

                    Shopware()->Db()->query("INSERT INTO s_articles_img_attributes (`imageID`,`attribute1`, `attribute2`) 
                VALUES (?,?,?)", [$mediaID, $Ring->getImageHash(), $Ring->getImageLink()]);

                }

            }
        }

        if(count($articlesFields) === 250) {
            echo json_encode(["productID" => $this->Afterbuy->getLastProductID(), "count" => $counter, "errorLog" => [], "ringName" => $ringName]);
        } else {
            die(true);
        }

    }

    public function errorAction() {

    }

    public function getWhitelistedCSRFActions()
    {
        return ['import', 'addArticles', 'export', 'error'];
    }

    private function getCategories() {
        return Shopware()->Db()->fetchAll("SELECT ID,description as name FROM s_categories WHERE parent = ?", $this->config['root_cat']);
    }

}
