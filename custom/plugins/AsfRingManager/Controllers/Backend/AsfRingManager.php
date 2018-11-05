<?php

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_AsfRingManager extends Enlight_Controller_Action implements CSRFWhitelistAware
{

    use AsfAfterbuy\Traits\Calculator;

    /**
     * @var int
     */
    private $catID;

    /**
     * @var array
     */
    private $config;

    /**
     * @var null|Components/AsfAfterbuy
     */
    private $Afterbuy = null;

    /**
     * @var string
     */
    private $msg = "";

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
     * Nothing to do, because index is only for information about the afterbuy interface
     */
    public function indexAction() {
        $this->importToShopwareAction();
    }

    public function importToShopwareAction() {

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

    /**
     * Shows the configuration
     */
    public function configAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        $ab_fields = Shopware()->Db()->fetchAll("SELECT * FROM asf_named_fields WHERE type = ?", "afterbuy");

        $subcats = Shopware()->Db()->fetchAll("SELECT DISTINCT value FROM `s_filter` a 
          LEFT JOIN s_filter_relations b 
          ON a.id = b.groupID 
          LEFT JOIN s_filter_options c 
          ON b.optionID = c.id 
          LEFT JOIN s_filter_values d 
          ON c.id = d.optionID
          WHERE a.name LIKE '%ringe' AND c.name LIKE 'Gold' OR c.name LIKE 'Material'");

        $sw_articles = Shopware()->Db()->fetchRow("SELECT * FROM s_articles LIMIT 1");
        $sw_details = Shopware()->Db()->fetchRow("SELECT * FROM s_articles_details LIMIT 1");
        $sw_prices = Shopware()->Db()->fetchRow("SELECT * FROM s_articles_prices LIMIT 1");

        $this->View()->assign("sw_articles", $sw_articles);
        $this->View()->assign("sw_details", $sw_details);
        $this->View()->assign("sw_prices", $sw_prices);
        $this->View()->assign("ab_fields", $ab_fields);
        $this->View()->assign("subcategories", $subcats);
        $this->View()->assign("cats", $this->getCategories());

    }

    /**
     * Write all Afterbuy fields in the database
     */
    public function setAfterbuyFieldsAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }


        Shopware()->Front()->Plugins()->ViewRenderer()->setNoRender();

        // If this parameter is set, it delete of the current afterbuy configuration
        if($this->Request()->getParam("reset", null) !== null) {
            Shopware()->Db()->query("TRUNCATE asf_named_fields; TRUNCATE asf_afterbuy_attribute_mapper;");
        }

        $this->Afterbuy->setRequest("GetShopProducts");
        $this->Afterbuy->setFilter("Level", 0);
        $this->Afterbuy->setResponse();
        $articleFields = $this->Afterbuy->getArticleData()[0];

        // Insert new fields and ignore given fields
        foreach($articleFields as $name => $value) {
            Shopware()->Db()->query("INSERT IGNORE INTO asf_named_fields (`type`, `name`) VALUES (?,?)",['afterbuy',$name]);
        }

        // The return of reset is needed for the reload via javascript
        if($this->Request()->getParam("reset", null) !== null) {
            echo "reset";
        } else {
            echo true;
        }

    }

    /**
     * Is called if the user click on "Preis Manager => Trauringe"
     */
    public function trauringeAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }


        $entries = Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_entries");

        if(empty($entries)) {
            return false;
        }

        $this->catID = $this->config['tr_catID'];

        $table = Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_entries WHERE catID = ?", $this->catID);

        $profiles = Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_profiles");
        $result = Shopware()->Db()->fetchRow("SELECT * FROM asf_price_manager_globals WHERE catID = ?", $this->catID);

        // Remove the categoryID, because it's not needed in template
        array_shift($result);

        $globals = [];
        $i = 0;

        foreach($result as $key => $entry) {
            $globals[$i]['name'] = $key;
            $globals[$i]['value'] = $entry;
            $i++;
        }

        $this->View()->assign("catName", Shopware()->Db()->fetchOne("SELECT `description` FROM s_categories WHERE id = ?",$this->catID));
        $this->View()->assign("profiles", $profiles);
        $this->View()->assign("table", $table);
        $this->View()->assign("globals", $globals);

        if($this->Request()->getParam('action') === "saveAndUpdateTrauringe") {
            $this->View()->assign("msg", "Preise wurden aktualisiert");
        }

    }

    /**
     * Is called if the user click on "Preis Manager => VerlobungsringeAction"
     */
    public function verlobungsringeAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        $brillant = Shopware()->Db()->fetchAll("SELECT carat,`g-si`,`g-vs`,`e-if` FROM asf_price_manager_brillant");
        $princess = Shopware()->Db()->fetchAll("SELECT carat,`g-si`,`g-vs`,`e-if` FROM asf_price_manager_princess");

        if(empty($brillant) && empty($princess)) {
            return false;
        }

        $this->catID = $this->config['vr_catID'];

        $result = Shopware()->Db()->fetchRow("SELECT * FROM asf_price_manager_globals WHERE catID = ?", $this->catID);

        // Remove the categoryID, because it's not needed in template
        array_shift($result);

        $globals = [];
        $i = 0;

        foreach($result as $key => $entry) {
            $globals[$i]['name'] = $key;
            $globals[$i]['value'] = $entry;
            $i++;
        }

        $this->View()->assign("catName", Shopware()->Db()->fetchOne("SELECT `description` FROM s_categories WHERE id = ?",$this->catID));
        $this->View()->assign("brillant", $brillant);
        $this->View()->assign("princess", $princess);
        $this->View()->assign("globals", $globals);

        if($this->Request()->getParam('action') === "saveAndUpdateVerlobungsringe") {
            $this->View()->assign("msg", "Preise wurden aktualisiert");
        }

    }

    /**
     *
     */
    public function saveAndUpdateTrauringeAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        $priceManager = $this->Request()->getParam('PriceManager');

        if(empty($priceManager['cat'])) {
            die("KategorieID fehlt im Formular");
        }

        // Save trauringe profile properties
        foreach($priceManager['entries'] as $key => &$val) {

            $val = str_replace(",", ".", $val);
            $parts = explode("_", $key);

            Shopware()->Db()->query("UPDATE `asf_price_manager_entries` SET `".$parts[2]."` = ? 
                WHERE alloy = ? AND material = ? AND catID = ?", [$val,$parts[0],$parts[1],$priceManager['cat']]);

        }

        $this->catID = $priceManager['cat'];

        // Save trauringe globals properties
        foreach($priceManager['globals'] as $key => &$val) {

            $val = str_replace(",", ".", $val);

            Shopware()->Db()->query("UPDATE `asf_price_manager_globals` SET `".$key."` = ? 
                WHERE catID = ?", [$val,$priceManager['cat']]);

        }

        $articles = Shopware()->Db()->fetchAll("SELECT a.id, a.name, b.attr5 as profile, b.attr6 as stone, b.attr7 as alloy,
            attr8 as width, attr9 as thickness, attr11 as quantity, attr13 as material FROM s_articles a LEFT JOIN s_articles_attributes b ON a.id = b.articleID
            LEFT JOIN s_articles_categories_ro c ON a.id = c.articleID WHERE c.categoryID = ?",$this->config['tr_catID']);

        foreach($articles as $article) {

            $function = $this->identifyStone($article['stone']);

            if($function == "calculateMaterial" || $function == "calculateTrauringe" || $function == "calculateZircon") {

                $result = $this->$function(($article['width'] * $article['thickness'])*2 ,$article['material'],$article['alloy'],$article['profile'],$article['stone'],$article['quantity']);

                if(is_array($result)) {
                    $price = $result[3];
                } else {
                    $price = $result;
                }

                Shopware()->Db()->query("UPDATE s_articles_prices SET price = ? WHERE articleID = ?", [$price,$article['id']]);
            }

        }

        $this->forward('trauringe');

    }

    /**
     *
     */
    public function saveAndUpdateVerlobungsringeAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        $priceManager = $this->Request()->getParam('PriceManager');

        if(empty($priceManager['cat'])) {
            die("KategorieID fehlt im Formular");
        }

        // Save diamond prices
        foreach($priceManager['entries'] as $key => &$val) {

            $val = str_replace(",", ".", $val);
            $parts = explode("_", $key);

            Shopware()->Db()->query("UPDATE `asf_price_manager_".$parts[0]."` SET `".$parts[2]."` = ? 
                WHERE carat = ?", [$val,$parts[1]]);

        }

        $this->catID = $priceManager['cat'];

        // Save trauringe globals properties
        foreach($priceManager['globals'] as $key => &$val) {

            $val = str_replace(",", ".", $val);

            Shopware()->Db()->query("UPDATE `asf_price_manager_globals` SET `".$key."` = ? 
                WHERE catID = ?", [$val,$priceManager['cat']]);

        }

        $articles = Shopware()->Db()->fetchAll("SELECT a.id, a.name, b.attr5 as profile, b.attr6 as stone, b.attr7 as alloy,
            attr8 as width, weight, attr11 as quantity, attr13 as material, attr14 FROM s_articles a LEFT JOIN s_articles_attributes b ON a.id = b.articleID
            LEFT JOIN s_articles_categories_ro c ON a.id = c.articleID LEFT JOIN s_articles_details d ON a.id=d.articleID WHERE c.categoryID = ?",$this->config['vr_catID']);

        foreach($articles as $article) {

            $function = $this->identifyStone($article['stone']);

            if($function == "calculateVerlobungsring") {

                $result = $this->$function($article['weight'],$article['material'],$article['alloy'],$article['stone'],$article['quantity'],$article['attr14']);

                if(is_array($result)) {
                    $price = $result[3];
                } else {
                    $price = $result;
                }

                Shopware()->Db()->query("UPDATE s_articles_prices SET price = ? WHERE articleID = ?", [$price,$article['id']]);
            }

        }

        $this->forward('verlobungsringe');

    }

    public function memoirenringeAction() {

        $roleID = Shopware()->Db()->fetchOne("SELECT roleID FROM s_core_auth WHERE sessionID = ?",session_id());

        if($roleID != "1") {
            $this->forward('error');
        }

        $brillant = Shopware()->Db()->fetchAll("SELECT carat,`g-si`,`g-vs`,`e-if` FROM asf_price_manager_brillant");
        $princess = Shopware()->Db()->fetchAll("SELECT carat,`g-si`,`g-vs`,`e-if` FROM asf_price_manager_princess");

        if(empty($brillant) && empty($princess)) {
            return false;
        }

        $this->catID = $this->config['ma_catID'];

        $result = Shopware()->Db()->fetchRow("SELECT * FROM asf_price_manager_globals WHERE catID = ?", $this->catID);

        // Remove the categoryID, because it's not needed in template
        array_shift($result);

        $globals = [];
        $i = 0;

        foreach($result as $key => $entry) {
            $globals[$i]['name'] = $key;
            $globals[$i]['value'] = $entry;
            $i++;
        }

        $this->View()->assign("catName", Shopware()->Db()->fetchOne("SELECT `description` FROM s_categories WHERE id = ?",$this->catID));

        $this->catID = $this->config['tr_catID'];

        $table = Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_entries WHERE catID = ?", $this->catID);

        $profiles = Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_profiles");


        $this->View()->assign("catName", Shopware()->Db()->fetchOne("SELECT `description` FROM s_categories WHERE id = ?",$this->catID));
        $this->View()->assign("profiles", $profiles);
        $this->View()->assign("table", $table);

        $this->View()->assign("brillant", $brillant);
        $this->View()->assign("princess", $princess);
        $this->View()->assign("globals", $globals);

        if($this->Request()->getParam('action') === "saveAndUpdateMemoirenringe") {
            $this->View()->assign("msg", "Preise wurden aktualisiert");
        }

    }

    public function saveAndUpdateMemoirenringeAction() {

        $articles = Shopware()->Db()->fetchAll("SELECT a.id,b.attr5, b.attr6, b.attr7, b.attr13, b.attr14,c.width,c.height,c.weight 
            FROM s_articles a LEFT JOIN s_articles_attributes b ON a.id = b.articleID LEFT JOIN s_articles_details c 
            ON b.articleID = c.articleID WHERE a.name LIKE 'Memoirering%'");

        foreach($articles as $article) {

            $stone = explode(" / ",$article['attr6'])[0];
            $tmpStone = $stone;

            $factor = 1;

            if(substr($article['attr14'],0,1) === "V") {
                $size = 54;
                if(substr($article['attr14'],1,1) === "H") {
                    if($article['attr7'] === "925er") {
                        $stone = "Halbkranz";
                    }
                    $factor = 2;
                } else {
                    if($article['attr7'] === "925er") {
                        $stone = "Vollkranz";
                    }
                }
                $gap = 0.2;
            } else {
                if(preg_match("/Kr/",$article['attr14'])) {
                    $size = 56;
                    if(substr($article['attr14'],2,1) === "H") {
                        if($article['attr7'] === "925er") {
                            $stone = "Halbkranz";
                        }
                        $factor = 2;
                    } else {
                        if($article['attr7'] === "925er") {
                            $stone = "Vollkranz";
                        }
                    }
                    $gap = 0.2;
                } else {
                    $size = 54;
                    if(substr($article['attr14'],1,1) === "H") {
                        if($article['attr7'] === "925er") {
                            $stone = "Halbkranz";
                        }
                        $factor = 2;
                    } else {
                        if($article['attr7'] === "925er") {
                            $stone = "Vollkranz";
                        }
                    }
                    $gap = 0;
                }
            }

            $outerDia = (($size / pi()) + ($article['height'] * 2)) * pi();

            $stoneDiameter = (float)Shopware()->Db()->fetchOne("SELECT diameter FROM asf_price_manager_memoire WHERE carat = ?",
                str_replace([",","ct."],[".",""],$tmpStone));

            $stones = floor(floor($outerDia / ($stoneDiameter + $gap)) / $factor);

            $article['weight'] = $stones * str_replace(",",".",$article['width']);

            if($article['attr7'] === "925er") {
                $this->clarity = "zirkonia";
            } else {
                $this->clarity = "g-si";
            }

            $result = $this->calculateMemoirering($article['width']*$article['height'], $article['attr13'], $article['attr7'],
                $article['attr5'], str_replace([",","ct."],[".",""],$stone), $stones,$size);

            if($result === null) {
                die(var_dump($result,$stones,$article));
            }

            if (is_array($result)) {
                $price = $result[3];
            } else {
                $price = $result;
            }

            Shopware()->Db()->query("UPDATE s_articles_details SET weight = ? WHERE articleID = ?",[str_replace([",","ct."],[".",""],$tmpStone)*$stones,$article['id']]);
            Shopware()->Db()->query("UPDATE s_articles_attributes SET attr11 = ? WHERE articleID = ?",[$stones,$article['id']]);
            Shopware()->Db()->query("UPDATE s_articles_prices SET price = ? WHERE articleID = ?",[$price,$article['id']]);

        }

        $this->forward('memoirenringe');

    }

    public function errorAction() {

    }

    public function getWhitelistedCSRFActions() {
        return ['saveAndUpdateTrauringe', 'saveAndUpdateVerlobungsringe', 'trauringe', 'verlobungsringe', 'memoirenringe', 'priceManager', 'priceManagerSave'];
    }

    private function getCategories() {
        return Shopware()->Db()->fetchAll("SELECT ID,description as name FROM s_categories WHERE parent = ?", $this->config['root_cat']);
    }

    private function getShopwareFields($tableName) {
        return Shopware()->Db()->fetchRow("SELECT * FROM " . $tableName . " LIMIT 0,1");
    }
}
