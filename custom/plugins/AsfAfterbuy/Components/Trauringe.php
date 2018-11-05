<?php

namespace AsfAfterbuy\Components;

use AsfAfterbuy\Components\Ring as Ring;

/**
 * Class Trauringe
 * @package AsfAfterbuy\Components
 */
final class Trauringe extends Ring {

    /**
     *
     */
    use \AsfAfterbuy\Traits\Calculator;

    /**
     * @var array
     */
    const DEFAULT_MIN_MAX_WIDTH = [2,12];

    /**
     * @var array
     */
    const DEFAULT_MIN_MAX_THICKNESS = [1.2,3];

    /**
     * @var string
     */
    const DESCRIPTION = " Günstige Trauringe ♥ Kostenlose Gravur ♥ Kostenloser Versand ♥ Made in Germany ♥";

    /**
     * @var int
     */
    const GW_POSITION = 0;

    /**
     * @var int
     */
    const RW_POSITION = 1;

    /**
     * @var int
     */
    const TRI_POSITION = 2;

    /**
     * @var int
     */
    const W_POSITION = 3;

    /**
     * @var int
     */
    const G_POSITION = 4;

    /**
     * @var int
     */
    const R_POSITION = 5;

    /**
     * @var int
     */
    const ROSE_POSITION = 6;

    /**
     * @var int
     */
    const PD_POSITION = 7;

    /**
     * @var int
     */
    const PL_POSITION = 8;


    /**
     * @var null|Shopware()->Db()
     */
    private $Db = null;

    /**
     * @var null|Shopware()->PluginLogger()
     */
    private $Logger = null;

    /**
     * @var int
     */
    private $catID = 0;

    /**
     * @var array|null
     */
    private $mapping = null;

    /**
     * @var string
     */
    private $display_name = "";

    /**
     * @var string
     */
    private $minMaxWidth = "";

    /**
     * @var string
     */
    private $minMaxThickness = "";

    /**
     * @var string 
     */
    private $width = "";

    /**
     * @var string 
     */
    private $thickness = "";
    
    /**
     * @var array
     */
    private $customProducts = [];

    /**
     * Trauringe constructor.
     * @param $name
     * @param $db
     * @param $cat
     * @param $Logger
     * @param null $config
     */
    public function __construct($name, $db, $cat, $Logger, $config = null) {

        $this->Logger = $Logger;
        $this->catID = $cat;
        $this->display_name = $name;
        $this->Db = $db;
        $this->mapping = $config;

    }

    /**
     * Loads a existing template and then the options or create a template
     */
    public function loadTemplate() {

        $this->display_name = $this . " " . $this->display_name;

        $this->customProducts['template_id'] = $this->Db->fetchOne("SELECT id FROM `s_plugin_custom_products_template` 
          WHERE `internal_name` = ?", $this->display_name);

        if(!empty($this->customProducts['template_id'])) {
            $this->loadOptions();
        } else {
            $this->createTemplate();
        }

    }

    /**
     * @return int
     */
    public function getTemplateId() {
        return $this->customProducts['template_id'];
    }

    /**
     * @return string
     */
    public function __toString() {
        return "Trauringe";
    }

    /**
     * Create a new template in custom products
     */
    private function createTemplate() {

        $this->Db->query("INSERT INTO `s_plugin_custom_products_template` (`internal_name`,`display_name`,`active`) VALUES
            (?,?,?)", [$this->display_name, $this->display_name, 1]);
        $this->customProducts['template_id'] = $this->Db->lastInsertId();

    }

    /**
     * Loads the current existing options in a template
     */
    private function loadOptions() {

        $result = $this->Db->fetchAll("SELECT * FROM `s_plugin_custom_products_option` WHERE template_id = ?",
            $this->customProducts['template_id']);

        foreach($result as $entry) {

            $key = $entry['name'];
            $this->customProducts['options'][$key] = [];
            unset($entry['name']);
            $entry['values'] = $this->getValuesFromOption($entry['id']);
            $this->customProducts['options'][$key] = $entry;

        }

    }

    /**
     * @param $id
     * @return array
     */
    private function getValuesFromOption($id) {

        $result = $this->Db->fetchAll("SELECT * FROM `s_plugin_custom_products_value` WHERE option_id = ?", $id);

        $values = [];

        foreach($result as $entry) {

            $key = $entry['name'];
            $values[$key] = [];
            unset($entry['name']);

        }

        return empty($values) === true ? []: $values;

    }

    /**
     * Helper function to use the right mapping function
     */
    public function dispatchMapping() {

        if($this->mapping === null) {
            $this->defaultMapping();
        } else {
            $this->configMapping();
        }

    }

    /**
     * @definition
     * ordernumber = Anr
     * shippingtime = FreeValue7
     * supplier = ProductBrand
     * description = articleName + self::description
     * description_long = ShortDescription
     * attr5 = FreeValue10 (Standard-Profil)
     * attr6 = FreeValue5 (Steinbesatz)
     * attr7 = FreeValue2 (Legierung)
     * attr8 = FreeValue3 (Standard-Breite)
     * attr9 = FreeValue6 (Standard-Stärke)
     * attr10 = FreeValue4 (Oberfläche)
     * attr11 = (attr6) (Steinanzahl)
     * attr12 = FreeValue8 (Modelname)
     * attr13 = FreeValue1 (Farbe)
     * attr14 = (attr6) (Schleifart)
     * attr15 = Attribut-Größe (Kleine Ringgröße)
     * attr16 = Attribut-Größe (Größte Ringgröße)
     * attr17 = manuell (Fehlende Ringgrößen)
     * attr18 = korrekter Import?
     * attr19 = Log-Statements
     * attr20 = minimale Breite
     * attr21 = maximale Breite
     * attr22 = minimale Stärke
     * attr23 = maximale Stärke
     * attr24 = aufbereiteter Steinbesatz
     * width = FreeValue3 (Standard-Breite)
     * thickness = FreeValue6 (Standard-Stärke)
     * weight = (Gesamt-Ct)
     * @return mixed|void
     */
    public function defaultMapping() {

        $this->attr18 = 1;
        $this->attr19 = "";

        $this->ordernumber = $this->articleData['Anr'];
        $this->shippingtime = substr($this->articleData['FreeValue7'],4, -5);

        if(empty($this->shippingtime)) {
            $this->shippingtime = "6 - 15";
            $this->attr19 .= "Hat keine Lieferzeit und bekam 6-15 zugewiesen.";
        }

        $this->attr13 = str_replace(["Rosegold","ss"],["Roségold","ß"],$this->articleData['FreeValue1']);

        $this->articleName = $this->display_name . " " . $this->articleData['FreeValue2'] . " " . $this->attr13 . " - " . substr($this->ordernumber,-4);
        $this->supplierName = empty($this->articleData['ProductBrand']) ? "Keine Angabe" : $this->articleData['ProductBrand'];

        $this->supplierID = Shopware()->Db()->fetchOne("SELECT id FROM s_articles_supplier WHERE name LIKE ?",$this->supplierName);
        if(empty($this->supplierID)) {
            Shopware()->Db()->query("INSERT INTO s_articles_supplier (`name`) VALUES (?)",$this->supplierName);
            $this->supplierID = Shopware()->Db()->lastInsertId();
        }

        $this->attr4 = $this->articleData['Profil'];
        $this->attr5 = $this->articleData['FreeValue10'];

        if(empty($this->attr5)) {
            $this->attr5 = 4;
            $this->attr19 .= "Hat kein Profil und bekam Profil4 zugewiesen.";
        }


        $this->attr6 = $this->articleData['FreeValue5'];
        $this->attr7 = $this->articleData['FreeValue2'];
        $this->width = str_replace(",",".",$this->articleData['FreeValue3']);

        if(empty($this->width)) {
            $this->width = "3";
            $this->attr19 .= "Hat keine Breite und bekam 3mm zugewiesen.";
        }

        $this->attr8 = $this->width;

        $this->thickness = str_replace(",",".",$this->articleData['FreeValue6']);

        if(empty($this->thickness)) {
            $this->thickness = "1.4";
            $this->attr19 .= "Hat keine Stärke und bekam 1,4mm zugewiesen.";
        }

        $this->attr9 = $this->thickness;

        $this->attr10 = $this->articleData['FreeValue4'];

        if(empty($this->attr10)) {
            $this->attr18 .= "Hat keine Oberfläche.";
        }

        $this->attr11 = 0;

        if($this->attr6 !== "ohne Steinbesatz") {
            $this->attr24 = $this->getSeparatedStoneQuantity($this->attr6);
            $this->attr11 = $this->getAmountOfStones($this->attr24);
        }


        $number = "";
        if(preg_match("/1/",$this->articleData['FreeValue8']) || preg_match("/2/",$this->articleData['FreeValue8'])) {
            $number = "-" . substr($this->articleData['FreeValue8'],-1);
            $this->attr12 = substr($this->articleData['FreeValue8'],0, -1);
        } else {
            $this->attr12 = $this->articleData['FreeValue8'];
        }

        $existWithStones = false;

        $url = "https://asf-trauringe.de/artikelbilder/".strtolower($this)."/" . $this->cleanString(str_replace("-/","-",strtolower($this->attr13)))."/";

        if($this->attr6 !== "Zirkonia") {

            if(preg_match("/ \/ /", $this->attr6)) {

                $stoneParts = explode(" / ", explode(" (", substr($this->attr6,0,-1))[1]);
                $concatStones = "";
                foreach($stoneParts as $key => $part) {

                    //$this->attr24 .= $part . "|";
                    $ct = explode(" x ", $part);

                    if(count($stoneParts) <= 3) {
                        $concatStones .= $ct[0] . "x" . str_replace([" ", ","], ["",""],explode("ct.", $ct[1])[0]) .  "-";
                    }

                }

                //$this->attr24 = substr($this->attr24,0,-1);

                $imageNameWithStones = str_replace(" ","",$this->cleanString(str_replace([" ","."],["-",""],strtolower($this->attr12))).
                    "-ner-".$this->cleanString(str_replace("-/","-",strtolower($this->attr13))) . "-" .
                    substr($concatStones,0,-1). $number . ".jpg");

            } else {
                $imageNameWithStones = $this->cleanString(str_replace([" ","."],["-",""],strtolower($this->attr12))).
                    "-ner-".$this->cleanString(str_replace("-/","-",strtolower($this->attr13)))."-".
                    str_replace(",","",str_replace(" ","",
                            explode("ct.",explode(" (",$this->attr6)[1])[0]). $number .".jpg");
            }

            $existWithStones = $this->url_exists($url.$imageNameWithStones);

        }

        $imageNameWithoutStones = $this->cleanString(str_replace([" ","."],["-",""],strtolower($this->attr12))). "-ner-".$this->cleanString(str_replace("-/","-",strtolower($this->attr13))) . $number;

        if(!empty($stoneParts) && count($stoneParts) > 3) {
            $imageNameWithoutStones .= "-" . count($stoneParts) . ".jpg";
        } else {
            $imageNameWithoutStones .= ".jpg";
        }

        $existWithoutStones = $this->url_exists($url.$imageNameWithoutStones);

        $imageWithoutAll = $this->cleanString(strtolower($this->attr12));
        $existWithoutAll = $this->url_exists($url.$imageWithoutAll);

        if($existWithStones) {
            $img = strtolower($this) . "-" . str_replace("-ner-", "-".$this->attr7."-", $imageNameWithStones);
            file_put_contents(__DIR__ . "/../Resources/images/".$img, file_get_contents($url.$imageNameWithStones));
        } elseif($existWithoutStones) {
            $img = strtolower($this) . "-" . str_replace("-ner-", "-".$this->attr7."-", $imageNameWithoutStones);
            file_put_contents(__DIR__ . "/../Resources/images/".$img, file_get_contents($url.$imageNameWithoutStones));
        } elseif($existWithoutAll) {
            $img = strtolower($this) . "-" . str_replace("-ner-", "-".$this->attr7."-", $imageWithoutAll);
            file_put_contents(__DIR__ . "/../Resources/images/".$img, file_get_contents($url.$imageWithoutAll));
        } else {
            $this->attr19 .= "Bild " . $url.$imageNameWithStones . " und " . $url.$imageNameWithoutStones . " nicht gefunden.";
        }

        $this->attr12 = $this->articleData['FreeValue8'];

        if(($existWithStones || §existsWithoutStones || $existWithoutAll) && !empty($img)) {
            $this->imageLink = __DIR__ . "/../Resources/images/" . $img;
            $this->imageHash = hash_file("md5", $this->imageLink);
        }

        if(preg_match("/Brillant/",$this->attr6) && preg_match("/Princess/",$this->attr6)) {
            $this->attr14 = "Brillant/Princess";
        } elseif(preg_match("/Brillant/",$this->attr6)) {
            $this->attr14 = "Brillant";
        } elseif(preg_match("/Princess/",$this->attr6)) {
            $this->attr14 = "Princess";
        } else {
            $this->attr14 = "Zirkonia";
        }

        $sizes = explode(";", substr($this->articleData['Damenring-Grösse'],1));
        array_pop($sizes);
        array_pop($sizes);

        $this->attr15 = substr(array_shift($sizes),0,2);
        $this->attr16 = substr(array_pop($sizes),0,2);

        if(!empty($this->articleData['FreeValue9'])) {

            $this->attr20 = explode("-", str_replace(",",".", explode(";",$this->articleData['FreeValue9'])[0]));
            $this->attr21 = $this->attr20[1];
            $this->attr20 = $this->attr20[0];
            $this->attr22 = explode("-", str_replace(",",".", explode(";",$this->articleData['FreeValue9'])[1]));
            $this->attr23 = $this->attr22[1];
            $this->attr22 = $this->attr22[0];

        } else {

            $this->attr20 = self::DEFAULT_MIN_MAX_WIDTH[0];
            $this->attr21 = self::DEFAULT_MIN_MAX_WIDTH[1];
            $this->attr22 = self::DEFAULT_MIN_MAX_THICKNESS[0];
            $this->attr23 = self::DEFAULT_MIN_MAX_THICKNESS[1];

        }

        if(!empty($this->attr19)) {
            $this->attr18 = 0;
        }

        $this->weight = $this->getAmountOfCarat($this->attr6);

        $this->description = $this->articleName . self::DESCRIPTION;

        $function = $this->identifyStone($this->attr6);

        if($function == "calculateMaterial" || $function == "calculateTrauringe" || $function == "calculateZircon") {

            $result = $this->$function(($this->width * $this->thickness)*2 ,$this->attr13,$this->attr7,$this->attr5,$this->attr6,$this->attr11);

            if(is_array($result)) {
                $price = $result[3];
            } else {
                $price = $result;
            }

            $this->price = $price;
        } else {
            $this->price = 0;
        }

    }

    /**
     * @return mixed|void
     */
    public function configMapping() {

    }

    /**
     * @return string
     */
    public function getImageLink() {
        return $this->imageLink;
    }

    /**
     * @return string
     */
    public function getImageHash() {
        return $this->imageHash;
    }

    /**
     * @return array
     */
    public function prepareImage() {
        return ["album" => -1, "name" => str_replace("---", "-", str_replace(" ", "-",str_replace("/","",$this->articleName))),
            "description" => str_replace("/","",str_replace("---", "-", str_replace(" ", "-",$this->articleName))),
            "file" => $this->imageLink, "userId" => 1];
    }

    /**
     * Fill the main article data and sets the articleID
     */
    public function createArticlesData() {

        $this->Db->query("INSERT INTO s_articles (`supplierID`,`name`, `metaTitle`,`description`,
            `shippingtime`,`datum`,`active`,`taxID`,`changetime`,`laststock`,`crossbundlelook`,`template`,`mode`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->supplierID, $this->articleName, $this->articleName, $this->description,
            $this->shippingtime, date("Y-m-d"), 1, 1, date("Y-m-d H:i:s"), 0, 0, 0, 0]);

        $this->setId($this->Db->lastInsertId());

    }

    /**
     * Fill the detail article data, sets the detailsID and update the main article data
     */
    public function createArticlesDetails() {

        $this->Db->query("INSERT INTO s_articles_details (`articleID`,`ordernumber`,`kind`,`active`,`instock`,
            `stockmin`,`position`,`weight`,`width`,`height`,`maxpurchase`,`minpurchase`,`shippingfree`, `shippingtime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->id,
            $this->ordernumber,1,1,10000,0,$this->getPosition(),$this->weight,$this->width,$this->thickness,1,1,1,$this->shippingtime]);

        $this->setDetailsId($this->Db->lastInsertId());
        $this->Db->query("UPDATE s_articles SET main_detail_id = ? WHERE id = ?", [$this->getDetailsId(),$this->getId()]);

    }

    /**
     * Fill the articles attributes
     */
    public function createArticlesAttributes() {

        $this->Db->query("INSERT INTO s_articles_attributes (`articleID`,`articledetailsID`,`attr4`,`attr5`,`attr6`,`attr7`,
            `attr8`,`attr9`,`attr10`,`attr11`,`attr12`,`attr13`,`attr14`,`attr15`,`attr16`,`attr17`,`attr18`,`attr19`,
            `attr20`,`attr21`,`attr22`,`attr23`,`attr24`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->id,$this->detailsId,$this->attr4,$this->attr5,$this->attr6,
            $this->attr7,$this->attr8,$this->attr9,$this->attr10,$this->attr11,$this->attr12,$this->attr13,$this->attr14,
            $this->attr15,$this->attr16,$this->attr17,$this->attr18,$this->attr19,$this->attr20,$this->attr21,$this->attr22,$this->attr23,$this->attr24]);

    }

    /**
     * Fill the price table
     */
    public function createArticlesPrices() {
        $this->Db->query("INSERT INTO s_articles_prices (pricegroup,`from`,`to`,articleID,articledetailsID,price,pseudoprice,percent) 
            VALUES (?,?,?,?,?,?,?,?)", ['EK', 1, 'beliebig', $this->id, $this->detailsId, $this->price, 0, 0]);
    }

    /**
     * @definition
     * ordernumber = Anr
     * shippingtime = FreeValue7
     * supplier = ProductBrand
     * attr4 = Profil
     * attr5 = FreeValue10 (Standard-Profil)
     * attr6 = FreeValue5 (Steinbesatz)
     * attr7 = FreeValue2 (Legierung)
     * width = FreeValue3 (Standard-Breite)
     * thickness = FreeValue6 (Standard-Stärke)
     * attr10 = FreeValue4 (Oberfläche)
     * @return void
     */
    public function createCustomProductsEntry() {

        $incrementID = (int)$this->Db->fetchOne("SELECT id FROM s_plugin_custom_products_value ORDER BY id DESC") + 1;

        if(empty($this->customProducts['options'])) {

            /**********************************************************************************************************
             * @option PROFIL ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Profil", $incrementID, 0, "radio", 0, 0, 3145728, 1, 1, 1, 0]);

            $optionId = $this->Db->lastInsertId();

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Standard-Profil", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $profilesWithValue = explode(";", $this->attr4);

            foreach($profilesWithValue as $profileWithValue) {

                $profile = explode(":", $profileWithValue)[0];

                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                    [$optionId, $profile, $incrementID, 0, 0, 0]);

                $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

                $incrementID++;

            }

            /**********************************************************************************************************
             * @option PROFIL ENDE
             *********************************************************************************************************/
            /**********************************************************************************************************
             * @option RINGWAHL ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Ringwahl", $incrementID, 0, "radio", 1, 0, 3145728, 1, 1, 1, 0]);

            $optionId = $this->Db->lastInsertId();

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Paarringe", $incrementID, 1, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Damenring", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Herrenring", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @option RINGWAHL ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @package DAMEN
             * @option DAMENRING-GRÖßE ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Damenring-Größe", $incrementID, 0, "select", 2, 0, 3145728, 1, 1, 1, 0]);

            $optionId = $this->Db->lastInsertId();

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $sizes = explode(";", substr($this->articleData['Damenring-Grösse'],1, -1));
            array_pop($sizes);
            
            foreach($sizes as $key => $size) {
                
                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`, `is_default_value`, 
                    `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$optionId, $size, $incrementID, 0, 0, 0]);

                $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, 
                    `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", 
                    [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);
                
                $incrementID++;
                
            }

            /**********************************************************************************************************
             * @option DAMENRING-GRÖßE ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option DAMENRING-BREITE ANFANG
             *********************************************************************************************************/
            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `default_value`,`min_value`, `max_value`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Damenring-Breite", $incrementID, 0, "numberfield", 3, 1, 3145728, 1, 0.5, 0,
                $this->width,self::DEFAULT_MIN_MAX_WIDTH[0],self::DEFAULT_MIN_MAX_WIDTH[1], 0]);
            
            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);
            
            $incrementID++;
            
            /**********************************************************************************************************
             * @option DAMENRING-BREITE ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option DAMENRING-STÄRKE ANFANG
             *********************************************************************************************************/
            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `default_value`,`min_value`, `max_value`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Damenring-Stärke", $incrementID, 0, "numberfield", 4, 1, 3145728, 1, 0.1, 0,
                $this->thickness, self::DEFAULT_MIN_MAX_THICKNESS[0],self::DEFAULT_MIN_MAX_THICKNESS[1], 0]);
            
            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @package DAMEN
             * @option DAMENRING-STÄRKE ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @package HERREN
             * @option HERRENRING-GRÖßE ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Herrenring-Größe", $incrementID, 0, "select", 5, 1, 3145728, 1, 1, 1, 0]);

            $optionId = Shopware()->Db()->lastInsertId();
            Shopware()->Db()->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                    `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $sizes = explode(";", substr($this->articleData['Herrenring-Grösse'],1, -1));
            array_pop($sizes);

            foreach($sizes as $size) {

                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`, `is_default_value`, 
                    `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$optionId, $size, $incrementID, 0, 0, 0]);

                $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, 
                    `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                    [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

                $incrementID++;

            }

            /**********************************************************************************************************
             * @option HERRENRING-GRÖßE ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option HERRENRING-BREITE ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `default_value`,`min_value`, `max_value`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Herrenring-Breite", $incrementID, 0, "numberfield", 6, 1, 3145728, 1, 0.5, 0,
                    $this->width, self::DEFAULT_MIN_MAX_WIDTH[0], self::DEFAULT_MIN_MAX_WIDTH[1], 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @option HERRENRING-BREITE ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option HERRENRING-STÄRKE ANFANG
             *********************************************************************************************************/
            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `default_value`,`min_value`, `max_value`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Herrenring-Stärke", $incrementID, 0, "numberfield", 7, 1, 3145728, 1, 0.1, 0,
                    $this->thickness, self::DEFAULT_MIN_MAX_THICKNESS[0], self::DEFAULT_MIN_MAX_THICKNESS[1], 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @package HERREN
             * @option HERRENRING-STÄRKE ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @package DAMEN
             * @option DAMENRING-GRAVUR ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `placeholder`, `is_once_surcharge`, `max_text_length`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->customProducts['template_id'], "Damenring-Gravur",
                $incrementID, 0, "textfield", 8, 'max. 45 Zeichen', 0, 45, 3145728, 1, 1, 0, 0]);

            $optionId = $this->Db->lastInsertId();
            Shopware()->Db()->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @package DAMEN
             * @option DAMENRING-GRAVUR ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @package HERREN
             * @option HERRENRING-GRAVUR ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `placeholder`, `is_once_surcharge`, `max_text_length`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->customProducts['template_id'], "Herrenring-Gravur",
                $incrementID, 0, "textfield", 9, 'max. 45 Zeichen', 0, 45, 3145728, 1, 1, 0, 0]);

            $optionId = $this->Db->lastInsertId();
            Shopware()->Db()->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @package HERREN
             * @option HERRENRING-GRAVUR ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option NOTIZ ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Notiz", $incrementID, 0, "textfield", 10, 0, 3145728, 1, 1, 0, 0]);

            $optionId = $this->Db->lastInsertId();
            Shopware()->Db()->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @option NOTIZ ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option LEGIERUNG ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Legierung", $incrementID, 0, "radio", 11, 0, 3145728, 1, 1, 1, 0]);

            $optionId = Shopware()->Db()->lastInsertId();
            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, $this->attr7, $incrementID, 0, substr($this->attr7,0, -2), 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @option LEGIERUNG ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option STEINBESATZ ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)", [$this->customProducts['template_id'],
                "Steinbesatz", $incrementID, 0, "radio", 12, 0, 3145728, 1, 1, 1, 0]);

            $optionId = $this->Db->lastInsertId();

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                    `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                      `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$optionId, "Ohne Stein/e", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                    `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            if($this->attr6 !== "ohne Steinbesatz") {

                if($this->attr6 !== "Zirkonia") {
                    $stone = substr(explode(" (",$this->attr6)[1],0,-1);
                } else {
                    $stone = $this->attr6;
                }

                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                      `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$optionId, $stone, $incrementID, 0, $this->getAmountOfStones($this->attr24), 0]);

                $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                    `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

                $incrementID++;

            }

            /**********************************************************************************************************
             * @option STEINBESATZ ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option SCHRIFTARTEN ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Schriftart", $incrementID, 0, "radio", 14, 0, 3145728, 1, 1, 1, 0]);

            $optionId = $this->Db->lastInsertId();

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Schrift1", $incrementID, 1, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Schrift2", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Schrift3", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Schrift4", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "Schrift5", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            /**********************************************************************************************************
             * @option SCHRIFTARTEN ENDE
             *********************************************************************************************************/

        } else {

            /**********************************************************************************************************
             * @option LEGIERUNG ANFANG
             *********************************************************************************************************/

            $incrementID++;

            $result = $this->Db->fetchOne("SELECT id FROM s_plugin_custom_products_value WHERE `option_id` = ? AND `name` LIKE ?",
                [$this->customProducts['options']['Legierung']['id'], $this->attr7]);

            if(empty($result)) {

                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                    [$this->customProducts['options']['Legierung']['id'], $this->attr7, $incrementID, 0, substr($this->attr7, 0,-2), 0]);

                $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                    `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

                $incrementID++;

            }

            /**********************************************************************************************************
             * @option LEGIERUNG ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option STEINBESATZ ANFANG
             *********************************************************************************************************/
            if($this->attr6 !== "Zirkonia") {

                $stone = substr(explode("(", $this->attr6)[1],0,-1);
                $position = $this->getAmountOfStones($this->attr24);

            } else {
                $stone = $this->attr6;
                $position = 1;
            }

            $result = $this->Db->fetchOne("SELECT id FROM s_plugin_custom_products_value WHERE `option_id` = ? AND `name` LIKE ?",
                [$this->customProducts['options']['Steinbesatz']['id'], $stone]);

            if(empty($result) && $stone !== "ohne Steinbesatz") {

                if($this->attr6 !== "Zirkonia") {
                    $stone = substr(explode(" (",$this->attr6)[1],0,-1);
                } else {
                    $stone = $this->attr6;
                }

                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,`is_default_value`, 
                `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$this->customProducts['options']['Steinbesatz']['id'],
                    $stone, $incrementID, 0, $this->getAmountOfStones($this->attr24), 0]);

                $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            }

            /**********************************************************************************************************
             * @option STEINBESATZ ENDE
             *********************************************************************************************************/

        }

        $this->Db->query("INSERT INTO s_plugin_custom_products_template_product_relation (`template_id`, `article_id`) 
        VALUES (?,?)", [$this->customProducts['template_id'],$this->id]);

    }

    /**
     * @todo complete all properties for article description on detail
     */
    public function createFilters() {

        // Add width as filter
        $this->Db->query("INSERT INTO `s_filter_articles` (`articleID`,`valueID`) VALUES (?,?)",
            [$this->id,$this->Db->fetchOne("SELECT `id` FROM `s_filter_values` WHERE `value` = ?",$this->width."mm")]);

        // Add stone quantity as filter
        $this->Db->query("INSERT INTO `s_filter_articles` (`articleID`,`valueID`) VALUES (?,?)",
            [$this->id,$this->Db->fetchOne("SELECT `id` FROM `s_filter_values` WHERE `value` = ?",$this->attr11)]);


        // Add alloy as filter
        $this->Db->query("INSERT INTO `s_filter_articles` (`articleID`,`valueID`) VALUES (?,?)",
            [$this->id,$this->Db->fetchOne("SELECT `id` FROM `s_filter_values` WHERE `value` = ?",$this->attr7)]);

        // Add surface as filter
        $this->Db->query("INSERT INTO `s_filter_articles` (`articleID`,`valueID`) VALUES (?,?)",
            [$this->id,$this->Db->fetchOne("SELECT `id` FROM `s_filter_values` WHERE `value` = ?",$this->attr10)]);

    }

    /**
     * @return mixed
     */
    public function getColor() {
        return $this->attr13;
    }

    /**
     * @return int
     */
    private function getPosition() {

        switcH($this->attr13) {

            case "Gelb-/Weißgold":
                return self::GW_POSITION;

            case "Rot-/Weißgold":
                return self::RW_POSITION;

            case "Tricolorgold":
                return self::TRI_POSITION;

            case "Weißgold":
                return self::W_POSITION;

            case "Gelbgold":
                return self::G_POSITION;

            case "Rotgold":
                return self::R_POSITION;

            case "Roségold":
                return self::ROSE_POSITION;

            case "Palladium":
                return self::PD_POSITION;

            case "Platin":
                return self::PL_POSITION;

            default :
                die(var_dump($this->attr13));

        }

    }

}