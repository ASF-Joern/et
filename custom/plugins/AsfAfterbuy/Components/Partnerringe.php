<?php

namespace AsfAfterbuy\Components;

/**
 * Class Partnerringe
 * @package AsfAfterbuy\Components
 */
final class Partnerringe extends Ring {

    const DESCRIPTION = " Günstige Partnerringe ❤ Große Auswahl an Partnerringen ❤ Günstig bestellen ❤ Gratis Gravur ❤ Gratis Versand ❤ Gratis Ringetui.";

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
    private $thickness = "";

    /**
     * @var array
     */
    private $customProducts = [];

    /**
     * Paarringe constructor.
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
        return "Partnerringe";
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
     * attr6 = FreeValue5 (Steinbesatz)
     * attr8 = FreeValue3 (Standard-Breite)
     * attr9 = FreeValue6 (Standard-Stärke)
     * attr10 = FreeValue4 (Oberfläche)
     * attr11 = Steinanzahl
     * attr12 = FreeValue8 (Modelname)
     * attr13 = FreeValue1 (Farbe)
     * width = FreeValue3 (Standard-Breite)
     * thickness = FreeValue6 (Standard-Stärke)
     * @return mixed|void
     */
    public function defaultMapping() {

        $this->ordernumber = $this->articleData['Anr'];
        $this->shippingtime = substr($this->articleData['FreeValue7'],4, -5);

        if(empty($this->shippingtime)) {
            $this->attr7 = "6 - 15";
        }

        if($this->articleData['FreeValue1'] === "925er Silber") {
            $this->display_name = str_replace("Partnerringe","Partnerringe / Freundschaftsringe",$this->display_name);
        } else {
            $this->display_name = str_replace("Partnerringe","ASF Trauringe Partnerringe",$this->display_name);
        }

        $this->articleName = $this->display_name . " " . $this->articleData['FreeValue1'] . " - " . substr($this->ordernumber,-4);
        $this->supplierName = empty($this->articleData['ProductBrand']) ? "Keine Angabe" : $this->articleData['ProductBrand'];

        $this->supplierID = Shopware()->Db()->fetchOne("SELECT id FROM s_articles_supplier WHERE name LIKE ?",$this->supplierName);
        if(empty($this->supplierID)) {
            Shopware()->Db()->query("INSERT INTO s_articles_supplier (`name`) VALUES (?)",$this->supplierName);
            $this->supplierID = Shopware()->Db()->lastInsertId();
        }

        $this->price = ((int)$this->articleData["SellingPrice"]) / 1.19;

        $this->attr6 = $this->articleData['FreeValue5'];
        $this->width = str_replace(",",".",$this->articleData['FreeValue3']);
        $this->attr8 = $this->width;
        $this->thickness = str_replace(",",".",$this->articleData['FreeValue6']);
        $this->attr9 = $this->thickness;
        $this->attr10 = $this->articleData['FreeValue4'];

        $this->attr11 = 0;

        $this->attr12 = $this->articleData['FreeValue8'];
        $this->attr13 = $this->articleData['FreeValue1'];

        //$url = "https://asf-trauringe.de/artikelbilder/".strtolower($this)."/" . $this->cleanString(str_replace("925er ","",strtolower($this->attr13)))."/";

        if($this->url_exists($this->articleData['ImageSmallURL'])) {
            $this->imageLink = $this->articleData['ImageSmallURL'];
            $this->imageHash = hash_file("md5", $this->imageLink);
        }

        $this->description = $this->articleName . self::DESCRIPTION;
        $this->description_long = $this->setDescriptionLong();

    }

    /**
     * @return mixed|void
     */
    public function configMapping() {

    }

    private function setDescriptionLong() {

        $description = '<div class="product--properties desc_box_table" itemprop="description">
            <table class="product--properties-table">
                <tbody>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Material/Farbe:</td>
                    <td class="product--properties-value" id="table_matleg">#FARBE#</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Oberfläche:</td>
                    <td class="product--properties-value" id="table_surface">#OBERFLÄCHE#</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Steinbesatz:</td>
                    <td class="product--properties-value" id="table_stone">#STEINBESATZ#</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Ringbreite:</td>
                    <td class="product--properties-value">#BREITE#</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Ringstärke:</td>
                    <td class="product--properties-value">#STÄRKE#</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Lieferzeit:</td>
                    <td class="product--properties-value">ca. #LIEFERZEIT# Tage</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Größen:</td>
                    <td class="product--properties-value">#GRÖßEN#</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Herkunftsland:</td>
                    <td class="product--properties-value">Deutschland</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Herstellung:</td>
                    <td class="product--properties-value">Hauseigene Produktion</td>
                </tr>';
        if(!empty($this->articleData['Memo'])) {

            $description .= '<tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Trauring-Beschreibung:</td>
                    <td class="product--properties-value">#MEMOFELD#</td>
                </tr>';

        }
        $description .= '</tbody>
            </table>
        </div>
        <div class="desc_box_vorteile">
            <h4>Unsere Vorteile</h4>
            <ul class="vorteile-tabelle">
                <li>Kostenlose Gravur</li>
                <li>Kostenloses Etui</li>
                <li>Kostenloser Versand</li>
                <li>Allergiefrei</li>
                <li><a href="/serviceleistungen#lebenslange-garantie" alt="trauringe-lebenslange-garantie"
                       title="Mehr erfahren zur lebenslangen Garantie" target="_blank">Lebenslange Garantie</a>
                </li>
                <li>Made in Germany</li>
            </ul>
            <div style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>
        ';

        $description = str_replace("#FARBE#", $this->articleData['FreeValue1'], $description);
        $description = str_replace("#OBERFLÄCHE#", $this->attr10, $description);
        $description = str_replace("#STEINBESATZ#", $this->attr6, $description);
        $description = str_replace("#BREITE#", $this->width . " mm", $description) ;
        $description = str_replace("#STÄRKE#", str_replace(".",",",$this->thickness). " mm", $description);
        $description = str_replace("#LIEFERZEIT#", $this->shippingtime, $description);

        $wSize = explode(";", substr($this->articleData['Damenring-Grösse'],1))[0];
        $mSize = array_pop(explode(";", substr($this->articleData['Herrenring-Grösse'],1)));

        $description = str_replace("#GRÖßEN#", substr(array_shift($wSize),0,2) . " - " . substr($mSize,0,4), $description);
        $description = str_replace("#RING-NAME#", $this->articleData['FreeValue8'], $description);
        $description = str_replace("#STEINBESATZ-VORKLAMMER#", $this->attr6, $description);
        $description = str_replace("#PREIS#", $this->articleData["SellingPrice"] . " €", $description);

        return $description;

    }

    public function updateDescriptionLong($namespace, $value) {
        $this->description_long = str_replace($namespace,$value,$this->description_long);
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
        return ["album" => -1, "name" => $this->articleName,
            "description" => $this->articleData['FreeValue8'] . " " . $this->articleData['FreeValue1'],
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
            `stockmin`,`position`,`width`,`height`,`maxpurchase`,`minpurchase`,`shippingtime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)", [$this->id,
            $this->ordernumber,1,1,10000,0,0,$this->width,$this->thickness,1,1,$this->shippingtime]);

        $this->setDetailsId($this->Db->lastInsertId());
        $this->Db->query("UPDATE s_articles SET main_detail_id = ? WHERE id = ?", [$this->getDetailsId(),$this->getId()]);

    }

    /**
     * Fill the articles attributes
     */
    public function createArticlesAttributes() {

        $this->Db->query("INSERT INTO s_articles_attributes (`articleID`,`articledetailsID`,`attr4`,`attr5`,`attr6`,
            `attr8`,`attr9`,`attr10`,`attr11`,`attr12`,`attr13`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?)", [$this->id,$this->detailsId,$this->attr4,$this->attr5,$this->attr6,$this->attr8,$this->attr9,$this->attr10,$this->attr11,$this->attr12,$this->attr13]);

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
     * attr6 = FreeValue5 (Steinbesatz)
     * width = FreeValue3 (Standard-Breite)
     * thickness = FreeValue6 (Standard-Stärke)
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
             * @package HERREN
             * @option HERRENRING-GRÖßE ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, 
                `ordernumber`, `required`, `type`, `position`, `is_once_surcharge`, `max_file_size`, `max_files`, 
                `interval`, `could_contain_values`, `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                [$this->customProducts['template_id'], "Herrenring-Größe", $incrementID, 0, "select", 2, 1, 3145728, 1, 1, 1, 0]);

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
             * @package DAMEN
             * @option DAMENRING-GRAVUR ANFANG
             *********************************************************************************************************/

            $this->Db->query("INSERT INTO s_plugin_custom_products_option (`template_id`, `name`, `ordernumber`, `required`, 
                `type`, `position`, `placeholder`, `is_once_surcharge`, `max_text_length`, `max_file_size`, `max_files`, `interval`, `could_contain_values`, 
                `allows_multiple_selection`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$this->customProducts['template_id'], "Damenring-Gravur",
                $incrementID, 0, "textfield", 1, 'max. 45 Zeichen', 0, 45, 3145728, 1, 1, 0, 0]);

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
                $incrementID, 0, "textfield", 3, 'max. 45 Zeichen', 0, 45, 3145728, 1, 1, 0, 0]);

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

        }

        $this->Db->query("INSERT INTO s_plugin_custom_products_template_product_relation (`template_id`, `article_id`) 
        VALUES (?,?)", [$this->customProducts['template_id'],$this->id]);

    }

    public function getColor() {
        return $this->attr13;
    }

}