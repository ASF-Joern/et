<?php

namespace AsfAfterbuy\Components;

use AsfAfterbuy\Components\PriceCalculator;

/**
 * Class Verlobungsring
 * @package AsfAfterbuy\Components
 */
final class Verlobungsring extends Ring {

    /**
     *
     */
    use \AsfAfterbuy\Traits\Calculator;

    const DESCRIPTION = " Günstige Verlobungsring ♥ Kostenlose Gravur ♥ Kostenloser Versand ♥ Made in Germany ♥";

    /**
     * @var int
     */
    const GW_POSITION = 4;

    /**
     * @var int
     */
    const WG_POSITION = 5;

    /**
     * @var int
     */
    const RW_POSITION = 6;

    /**
     * @var int
     */
    const WR_POSITION = 7;

    /**
     * @var int
     */
    const W_POSITION = 1;

    /**
     * @var int
     */
    const G_POSITION = 0;

    /**
     * @var int
     */
    const R_POSITION = 2;

    /**
     * @var int
     */
    const ROSE_POSITION = 3;

    /**
     * @var null
     */
    private $Db = null;

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
    private $width = "";

    /**
     * @var string
     */
    private $weight = "";

    /**
     * @var array
     */
    private $customProducts = [];

    /**
     * @var string
     */
    private $attr14 = "";

    /**
     * Verlobungsring constructor.
     * @param $name
     * @param $db
     * @param null $config
     */
    public function __construct($name, $db, $config = null) {

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
        return "Verlobungsring";
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
     * attr5 = Profil4
     * attr6 = FreeValue5 (Steinbesatz)
     * attr7 = FreeValue2 (Legierung)
     * width = FreeValue3 (Standard-Breite)
     * weight = FreeValue6 (Gewicht)
     * attr10 = FreeValue4 (Oberfläche)
     * attr11 = FreeValue9 (Steinanzahl)
     * attr12 = FreeValue8 (Modelname)
     * attr13 = FreeValue1 (Farbe/Material)
     * attr14 = FreeValue10 (Schleifart)
     * attr18 = korrekter Import?
     * attr19 = Log-Statements
     * @return mixed|void
     */
    public function defaultMapping() {

        $this->attr18 = 1;
        $this->attr19 = "";
        $this->ordernumber = $this->articleData['Anr'];
        $this->shippingtime = substr($this->articleData['FreeValue7'],4, -5);

        if(empty($this->shippingtime)) {
            $this->attr19 .= "Keine Lieferzeit eingetragen, 6-15 wurden zugewiesen.";
            $this->shippingtime = "6 - 15";
        }

        $this->attr13 = str_replace("Rosegold", "Roségold", str_replace("ss", "ß", $this->articleData['FreeValue1']));

        $this->articleName = $this->display_name . " " . $this->articleData['FreeValue2'] . " " . $this->articleData['FreeValue1'] . " - " . substr($this->ordernumber,-4);
        $this->supplierName = empty($this->articleData['ProductBrand']) ? "Keine Angabe" : $this->articleData['ProductBrand'];

        $this->supplierID = Shopware()->Db()->fetchOne("SELECT id FROM s_articles_supplier WHERE name LIKE ?",$this->supplierName);
        if(empty($this->supplierID)) {
            Shopware()->Db()->query("INSERT INTO s_articles_supplier (`name`) VALUES (?)",$this->supplierName);
            $this->supplierID = Shopware()->Db()->lastInsertId();
        }

        $this->attr5 = 4;

        $this->attr6 = "1 x " . $this->articleData['FreeValue5'];
        $this->attr7 = $this->articleData['FreeValue2'];
        $this->width = $this->articleData['FreeValue3'];

        if(empty($this->width)) {
            $this->attr19 .= "Hat keine Breite, es wurde 9999 zugewiesen.";
            $this->width = "9999";
        }

        $this->weight = str_replace(",",".",$this->articleData['FreeValue6']);

        if(empty($this->weight)) {
            $this->attr19 .= "Hat kein Gewicht, es wurden 1000 zugewiesen.";
            $this->weight = "1000";
        }

        $this->attr10 = $this->articleData['FreeValue4'];

        if(empty($this->attr10)) {
            $this->attr19 .= "Oberfläche ist leer";
        }

        $this->attr12 = $this->articleData['FreeValue8'];

        $existWithStones = false;

        $url = "https://asf-trauringe.de/artikelbilder/".strtolower($this)."/" . $this->cleanString(str_replace("-/","-",strtolower($this->attr13)))."/";

        if($this->attr6 !== "Zirkonia") {

            if(preg_match("/ \/ /", $this->attr6)) {

                $stoneParts = explode(" / ", $this->attr6);
                $concatStones = "";
                $switcher = 0;
                foreach($stoneParts as $key => $part) {

                    if($switcher == 1 || $switcher == 3 || $switcher == 5) {
                        continue;
                    }

                    $this->attr24 .= $part . "|";
                    $ct = explode(" x ", $part);

                    if(count($stoneParts) <= 3) {
                        $concatStones .= $ct[0] . "x" . str_replace([" ", ","], ["",""],explode("ct.", $ct[1])[0]) .  "-";
                    }

                    $switcher++;

                }

                $this->attr24 = substr($this->attr24,0,-1);

                $imageNameWithStones = str_replace(" ","",$this->cleanString(strtolower($this->attr12)).
                    "-ner-".$this->cleanString(str_replace("-/","-",strtolower($this->attr13))) . "-" .
                    substr($concatStones,0,-1).".jpg");

            } else {
                $imageNameWithStones = $this->cleanString(strtolower($this->attr12)).
                    "-ner-".$this->cleanString(str_replace("-/","-",strtolower($this->attr13)))."-".
                    str_replace(",","",str_replace(" ","",
                            explode("ct.",explode(" (",$this->attr6)[1])[0]).".jpg");
            }


            $existWithStones = $this->url_exists($url.$imageNameWithStones);

        }

        $imageNameWithoutStones = $this->cleanString(strtolower($this->attr12)). "-ner-".$this->cleanString(str_replace("-/","-",strtolower($this->attr13)));

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

        $this->attr11 = (string)$this->articleData['FreeValue9'];
        $this->attr14 = $this->articleData['FreeValue10'];

        if(!empty($this->attr19)) {
            $this->attr18 = 0;
        }

        $this->description = $this->articleName . self::DESCRIPTION;
        $this->price = 0.01;

        $function = $this->identifyStone($this->attr6);

        if($function == "calculateVerlobungsring") {

            $result = $this->$function($this->weight, $this->attr13, $this->attr7, $this->attr6, $this->attr11, $this->attr14);

            if (is_array($result)) {
                $price = $result[3];
            } else {
                $price = $result;
            }

        }

        $this->price = $price;

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
     * @return string
     */
    public function getDescriptionLong() {
        return $this->description_long;
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

        $this->Db->query("INSERT INTO s_articles (`supplierID`,`name`,`metaTitle`,`description`,`description_long`,
            `shippingtime`,`datum`,`active`,`taxID`,`changetime`,`laststock`,`crossbundlelook`,`template`,`mode`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->supplierID, $this->articleName, $this->articleName, $this->description,
            $this->description_long, $this->shippingtime, date("Y-m-d"), 1, 1, date("Y-m-d H:i:s"), 0, 0, 0, 0]);

        $this->setId($this->Db->lastInsertId());

    }

    /**
     * Fill the detail article data, sets the detailsID and update the main article data
     */
    public function createArticlesDetails() {

        $this->Db->query("INSERT INTO s_articles_details (`articleID`,`ordernumber`,`kind`,`active`,`instock`,
            `stockmin`,`position`,`width`,`weight`,`maxpurchase`,`minpurchase`,`shippingfree`, `shippingtime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->id,
            $this->ordernumber,1,1,10000,0,$this->getPosition(),$this->width,$this->weight,1,1,1,$this->shippingtime]);

        $this->setDetailsId($this->Db->lastInsertId());
        $this->Db->query("UPDATE s_articles SET main_detail_id = ? WHERE id = ?", [$this->getDetailsId(),$this->getId()]);

    }

    /**
     * Fill the articles attributes
     */
    public function createArticlesAttributes() {

        $this->Db->query("INSERT INTO s_articles_attributes (`articleID`,`articledetailsID`,`attr5`,`attr6`,`attr7`,
            `attr10`,`attr11`,`attr12`,`attr13`,`attr14`,`attr18`,`attr19`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)", [$this->id,$this->detailsId,$this->attr5,$this->attr6,$this->attr7,
            $this->attr10,$this->attr11,$this->attr12,$this->attr13,$this->attr14,$this->attr18,$this->attr19]);

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
     * @return void
     */
    public function createCustomProductsEntry() {

        $incrementID = (int)$this->Db->fetchOne("SELECT id FROM s_plugin_custom_products_value ORDER BY id DESC") + 1;

        if(empty($this->customProducts['options'])) {

            /**********************************************************************************************************
             * @package DAMEN
             * @option DAMENRING-GRÖßE ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Damenring-Größe", $incrementID, 0, "select", 0, 0, 3145728, 1, 1, 1, 0]);

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
             * @package DAMEN
             * @option DAMENRING-GRAVUR ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `placeholder`, `is_once_surcharge`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->customProducts['template_id'], "Damenring-Gravur",
                $incrementID, 0, "textfield", 2, 'max. 45 Zeichen', 0, 3145728, 1, 1, 0, 0]);

            $optionId = $this->Db->lastInsertId();
            Shopware()->Db()->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            /**********************************************************************************************************
             * @package DAMEN
             * @option DAMENRING-GRAVUR ENDE
             *********************************************************************************************************/

            /**********************************************************************************************************
             * @option NOTIZ ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Notiz", $incrementID, 0, "textfield", 1, 0, 3145728, 1, 1, 0, 0]);

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

            if($this->attr6 !== "Zirkonia") {
                $stone = $this->attr6;
                $position = (float)str_replace(",",".", explode("ct.", $this->attr6)[0]) * 100;
            }

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                      `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$optionId, $stone, $incrementID, 0, $position, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, `percentage`, `is_percentage_surcharge`, 
                    `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

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
                [$optionId, "Schrift1", $incrementID, 0, 0, 0]);

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

            /**********************************************************************************************************
             * @option REINHEIT ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Reinheit", $incrementID, 0, "radio", 15, 0, 3145728, 1, 1, 1, 0]);

            $optionId = $this->Db->lastInsertId();

            $this->Db->query("INSERT INTO s_plugin_custom_products_price (`option_id`, `surcharge`, `percentage`, 
                `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) VALUES (?,?,?,?,?,?,?)",
                [$optionId, 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "G/SI", $incrementID, 1, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "G/VS", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            $incrementID++;

            $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,
                    `is_default_value`, `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)",
                [$optionId, "E/IF", $incrementID, 0, 0, 0]);

            $this->Db->query("INSERT INTO s_plugin_custom_products_price  (`value_id`, `surcharge`, 
                    `percentage`, `is_percentage_surcharge`, `tax_id`, `customer_group_name`, `customer_group_id`) 
                    VALUES (?,?,?,?,?,?,?)", [$this->Db->lastInsertId(), 0, 0, 0, 1, "Shopkunden", 1]);

            /**********************************************************************************************************
             * @option REINHEIT ENDE
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
                $stone = $this->attr6;
                $position = (float)str_replace(",",".", explode("ct.", $this->attr6)[0]) * 100;
            }

            $result = $this->Db->fetchOne("SELECT id FROM s_plugin_custom_products_value WHERE `option_id` = ? AND `name` LIKE ?",
                [$this->customProducts['options']['Steinbesatz']['id'], $stone]);

            if(empty($result)) {

                $this->Db->query("INSERT INTO s_plugin_custom_products_value (`option_id`, `name`, `ordernumber`,`is_default_value`, 
                `position`, `is_once_surcharge`) VALUES (?,?,?,?,?,?)", [$this->customProducts['options']['Steinbesatz']['id'],
                    $stone, $incrementID, 0, $position, 0]);

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
     * Calculates the current price
     */
    private function calculatePrice() {

        $PriceCalculator = new PriceCalculator($this->Db,$this->Logger);
        $PriceCalculator->setValues(64,0,$this->weight,"verlobungsring",$this->attr7,$this->attr6,$this->attr13,true,false,1);
        return $PriceCalculator->calculatePrice();
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

            case "Weiß-/Gelbgold":
                return self::WG_POSITION;

            case "Weißgold":
                return self::W_POSITION;

            case "Gelbgold":
                return self::G_POSITION;

            case "Rotgold":
                return self::R_POSITION;

            case "Roségold":
                return self::ROSE_POSITION;

            case "Weiß-/Rotgold":
                return self::WR_POSITION;

        }

    }

}