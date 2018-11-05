<?php

namespace AsfRingManager\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\SearchBundle\FacetResult\MediaListItem;

class Detail implements SubscriberInterface {

    use \AsfAfterbuy\Traits\Calculator;
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @return array
     */
    public static function getSubscribedEvents() {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onPostDispatchDetail'
        ];
    }

    /**
     * Detail constructor.
     * @param $pluginName
     * @param $pluginDirectory
     */
    public function __construct($pluginName, $pluginDirectory) {
        $this->pluginDirectory = $pluginDirectory;
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName($pluginName);
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatchDetail(\Enlight_Controller_ActionEventArgs $args) {

        $controller = $args->getSubject();
        $view = $controller->View();

        $isMemoire = false;
        $article = $view->getAssign("sArticle");
        $articleID = $article['articleID'];

        $stones = Shopware()->Db()->fetchAll("SELECT c.name FROM  `s_plugin_custom_products_template_product_relation` a 
                  LEFT JOIN `s_plugin_custom_products_option` b
                  ON a.template_id = b.template_id
                  LEFT JOIN `s_plugin_custom_products_value` c 
                  ON b.id = c.option_id
                  WHERE b.name = 'Steinbesatz' AND c.name != 'Ohne Stein/e' AND article_id = ? ORDER BY c.position",$articleID);

        $template = Shopware()->Db()->fetchOne("SELECT internal_name 
            FROM `s_plugin_custom_products_template_product_relation` a
            LEFT JOIN `s_plugin_custom_products_template` b 
            ON a.template_id = b.id WHERE a.article_id = ?",$articleID);

        $memoireOpts = [];
        $ring = $this->identifyStone($article['attr6'],true);
        if($ring === "trauringe" || $ring === "verlobungsring" || preg_match("/Memoirering/",$article['articleName'])) {

            $stoneCollection = [];
            if(preg_match("/Memoirering/",$article['articleName'])) {
                $isMemoire = true;

                if(substr($article['attr14'],0,1) === "V") {
                    $memoireOpts['schnitt'] = "Verschnitt";
                    if(substr($article['attr14'],1,1) === "V") {
                        $memoireOpts['kranz'] = "Vollkranz";
                    }
                    if(substr($article['attr14'],1,1) === "H") {
                        $memoireOpts['kranz'] = "Halbkranz";
                    }
                }

                if(substr($article['attr14'],0,1) === "K") {
                    $memoireOpts['schnitt'] = "Kanal";
                    if(substr($article['attr14'],1,1) === "V") {
                        $memoireOpts['kranz'] = "Vollkranz";
                    }
                    if(substr($article['attr14'],1,1) === "H") {
                        $memoireOpts['kranz'] = "Halbkranz";
                    }
                }

                if(substr($article['attr14'],0,2) === "Kr") {
                    $memoireOpts['schnitt'] = "Krappenfassung";
                    if(substr($article['attr14'],2,1) === "V") {
                        $memoireOpts['kranz'] = "Vollkranz";
                    }
                    if(substr($article['attr14'],2,1) === "H") {
                        $memoireOpts['kranz'] = "Halbkranz";
                    }
                }

                $ct = $article['weight'];
            } else {
                $ct = $this->getAmountOfCarat($article['attr6'],$article['attr11']);
            }
            foreach($stones as $stone) {

                if(preg_match("/Memoirering/",$article['articleName'])) {
                    $stoneCollection[$stone['name']] = Shopware()->Db()->fetchOne("SELECT attr11 FROM s_articles_attributes a 
                    LEFT JOIN s_articles b 
                    ON a.articleID = b.id WHERE b.name LIKE '".$template."%' AND attr6 LIKE '%".$stone['name']."%'");
                } else {
                    $stoneCollection[$stone['name']] = $this->getAmountOfStones(Shopware()->Db()->fetchOne("SELECT attr24 FROM s_articles_attributes a 
                    LEFT JOIN s_articles b 
                    ON a.articleID = b.id WHERE b.name LIKE '".$template."%' AND attr6 LIKE '%".$stone['name']."%'"));
                }

            }
        }

        if($ring === "trauringe") {
            $article['attr6'] = substr(explode(" (", $article['attr6'])[1], 0, -1);
        }

        $catID = Shopware()->Db()->fetchOne("SELECT categoryID FROM s_articles_categories WHERE articleID = ? AND categoryID != 31", $articleID);
        $parentID = Shopware()->Db()->fetchOne("SELECT `parent` FROM s_categories WHERE id = ?", $catID);

        $asfTemplateFile = str_replace(" ","-",strtolower(Shopware()->Db()->fetchOne("SELECT description FROM s_categories WHERE id = ?", $parentID))) . ".tpl";

        $material = $this->identifyMaterial($article['articleName']);

        $article['refinement'] = "-";

        if(preg_match("/Brillant/",$article['attr6']) || preg_match("/Memoirering/",$article['articleName'])) {
            $article['refinement'] = "Brillant";
        }

        if(preg_match("/Princess/",$article['attr6'])) {
            $article['refinement'] = "Princess";
        }

        // Is needed to switch the template files in swag_custom_products_detail/default/index.tpl
        $view->assign("asfTemplateFile", $asfTemplateFile);
        $view->assign("asfColorSwitcher", $this->getColors($articleID,$article['attr7']));
        $view->assign("asfMaterial", $material);
        $view->assign("sArticle", $article);
        $view->assign("ring", $ring);
        $view->assign("amountOfStones",$stoneCollection);
        $view->assign("ct",str_replace(".",",",$ct));
        $view->assign("netCt",$ct);
        $view->assign("isMemoire",$isMemoire);
        $view->assign("memoireOpts",$memoireOpts);
        $view->assign("kranz","");

    }

    /**
     * @param $articleID
     * @param $alloy
     * @return array
     */
    private function getColors($articleID,$alloy) {

        $colors = [];
        $model = Shopware()->Db()->fetchOne("SELECT attr12 FROM s_articles_attributes WHERE articleID = ?",$articleID);

        if($alloy === "333er" || $alloy === "750er") {

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ? 
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 3),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            if(empty($result)) {

                $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ? 
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 4),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            }

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND attr7 = '585er'
                AND attr13 NOT LIKE '%gold'
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID]);

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name 
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND attr7 = '600er'
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID]);

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

        }

        if($alloy === "585er" || $alloy === "600er") {

            if($alloy === "585er") {
                $where = "'600er'";
            } else {
                $where = "'333er' OR (attr7 = '585er' AND attr13 = 'Palladium' AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = " . $articleID . " LIMIT 1))";
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name 
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 3),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            if(empty($result)) {

                $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name 
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 4),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            }

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
            FROM s_articles_attributes a 
            LEFT JOIN s_articles_details b 
            ON a.articleID=b.articleID 
            WHERE attr12 = ?
            AND attr7 = " . $where . "
            AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID]);

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

        }

        if($alloy === "950er") {

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND (attr7 = '333er' OR (attr7 = '585er' AND attr13 = 'Palladium' AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)))
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID  
                WHERE attr12 = ?
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 3),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            if(empty($result)) {

                $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID  
                WHERE attr12 = ?
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 4),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            }

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

        }

        $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name 
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND attr7 = '925er'
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
            [$model,$articleID]);

        foreach($result as $entry) {
            $colors[$entry['position']] = $entry;
        }

        if($alloy === "925er") {

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND (attr7 = '333er' OR (attr7 = '585er' AND attr13 = 'Palladium' AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)))
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name 
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID 
                WHERE attr12 = ?
                AND attr7 = '600er'
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID]);

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

            $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID  
                WHERE attr12 = ?
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 3),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                [$model,$articleID,$articleID]);


            if(empty($result)) {

                $result = Shopware()->Db()->fetchAll("SELECT b.position, attr13 as name
                FROM s_articles_attributes a 
                LEFT JOIN s_articles_details b 
                ON a.articleID=b.articleID  
                WHERE attr12 = ?
                AND attr7 = (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 4),' ', -1) FROM s_articles WHERE id = ? LIMIT 1) 
                AND attr6 = (SELECT attr6 FROM s_articles_attributes WHERE articleID = ? LIMIT 1)",
                    [$model,$articleID,$articleID]);

            }

            foreach($result as $entry) {
                $colors[$entry['position']] = $entry;
            }

        }

        ksort($colors);
        return $colors;

    }
}