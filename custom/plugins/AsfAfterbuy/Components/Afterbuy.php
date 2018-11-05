<?php

namespace AsfAfterbuy\Components;

/**
 * Class Afterbuy
 * @package AsfAfterbuy\Components
 */
class Afterbuy {

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var null|\SimpleXMLElement
     */
    private $Request = null;

    /**
     * @var null|\SimpleXMLElement
     */
    private $Response = null;

    /**
     * @var null|\SimpleXMLElement
     */
    private $Result = null;

    /**
     * @var array
     */
    private $filter = [];

    /**
     * @var int
     */
    private $lastProductID = 0;

    /**
     * @var string
     */
    private $callName = '';

    /**
     * Afterbuy constructor.
     * @param $config
     */
    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * @param $name
     * @param int $itemQuantity
     */
    public function setRequest($name, $itemQuantity = 1) {

        $this->callName = $name;
        $XmlEmptyRequest = new \SimpleXMLElement(__DIR__ . '/../Resources/xml/' . $name . '.xml', null, true);
        $XmlRequest = $this->setLoginData($XmlEmptyRequest);

        if($name === "GetShopProducts" || $name === "GetSoldItems") {

            if($name === "GetSoldItems") {
                $XmlRequest->MaxSoldItems = $itemQuantity;
            } else {
                $XmlRequest->MaxShopItems = $itemQuantity;
            }


            foreach($XmlRequest->DataFilter->Filter as $Filter) {
                $this->filter[] = (string)$Filter->FilterName;
            }

        }

        $this->Request = $XmlRequest;

    }

    /**
     * @return null|\SimpleXMLElement
     */
    public function getRequest() {
        return $this->Request;
    }

    /**
     * @throws \Exception
     */
    public function setResponse() {

        if($this->callName === "GetShopProducts" && $this->lastProductID !== 0) {
            $this->setFilter("RangeID", [$this->lastProductID, '']);
        }

        $curl = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "https://api.afterbuy.de/afterbuy/ShopInterface.aspx");
        curl_setopt($curl, CURLOPT_URL, "https://api.afterbuy.de/afterbuy/ABInterface.aspx");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->Request->asXML());
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_LOW_SPEED_TIME, 60);
        curl_setopt($curl, CURLOPT_LOW_SPEED_LIMIT, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        try {

            $this->Response = new \SimpleXMLElement($result);
            $this->Result = $this->Response->Result;
            $this->filter = [];

            if($this->callName === "GetShopProducts") {
                $this->lastProductID = (int)$this->Result->LastProductID;
            }

            $this->createLog();

        } catch(Exception $e) {
            throw new \Exception("Falsche Übermittlung von Afterbuy: " . $e->getMessage());
        }

    }

    /**
     * @return null|\SimpleXMLElement
     */
    public function getResponse() {
        return $this->Response;
    }

    /**
     * @return null|\SimpleXMLElement
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * @param $name
     * @param $param
     */
    public function setFilter($name, $param) {

        $key = array_search($name,$this->filter);

        if($key !== false) {

            if(is_array($param)) {

                if($this->filter[$key] === "Level") {
                    $this->Request->DataFilter->Filter[$key]->FilterValues->LevelFrom = $param[0];
                    $this->Request->DataFilter->Filter[$key]->FilterValues->LevelTo = $param[1];
                } elseif($this->filter[$key] === "DateFilter") {
                    $this->Request->DataFilter->Filter[$key]->FilterValues->DateFrom = $param[0];
                    $this->Request->DataFilter->Filter[$key]->FilterValues->DateTo = $param[1];
                    $this->Request->DataFilter->Filter[$key]->FilterValues->FilterValue = "ModDate";
                } else {
                    $this->Request->DataFilter->Filter[$key]->FilterValues->ValueFrom = $param[0];
                    $this->Request->DataFilter->Filter[$key]->FilterValues->ValueTo = $param[1];

                }

            } else {

                if($this->filter[$key] === "Level") {
                    $this->Request->DataFilter->Filter[$key]->FilterValues->LevelValue = $param;
                } else {
                    $this->Request->DataFilter->Filter[$key]->FilterValues->FilterValue = $param;
                }

            }

        } else {
            die(var_dump($this->filter,$name,$param));
        }

    }

    /**
     * @return array
     */
    public function getArticleData() {

        $articleFields = [];

        $k = 0;

        foreach($this->Result->Products->Product as $Product) {

            foreach($Product as $fieldname => $fieldvalue) {

                if($fieldname == "Attributes") {

                    foreach($fieldvalue as $attrName => $attribute) {

                        $i = 0;
                        $lastKey = '';

                        foreach($attribute as $key => $val) {

                            switch($i) {

                                case 0: $lastKey = (string) $val;
                                    break;

                                case 1: $articleFields[$k][$lastKey] = (string) $val;
                                    break;
                            }

                            $i++;

                        }

                    }
                } else {
                    $articleFields[$k][$fieldname] = (string) $fieldvalue;
                }

            }
            $k++;
        }

        return $articleFields;

    }

    /**
     * @return string
     */
    public function getOrderLinkForDownload() {

        foreach($this->Result->Orders->Order as $Order) {

            $price = (float)str_replace(",",".", $Order->PaymentInfo->FullAmount);

            if($price <= 0) {
                continue;
            }

            return (string)$Order->FeedbackLink;
        }

    }

    /**
     * Here we parse
     * @return string
     */
    public function getInvoiceNumberForDownload() {

        foreach($this->Result->Orders->Order as $Order) {

            $price = (float)str_replace(",",".", $Order->PaymentInfo->FullAmount);

            if($price <= 0) {
                continue;
            }

            return (string)$Order->InvoiceNumber;
        }

    }

    /**
     * @description Sets the ProductID which product get new attributes in afterbuy
     *
     * @param $Product\SimpleXMLElement
     */
    public function setAttributAddProductID($Product) {

        foreach($this->Request->Products as $Products) {

            $child = $Products->addChild("Product");

            foreach($Product as $name => $children) {

                $subchild = $child->addChild($name, (string)$children[0]);

                if($children->children()->count() > 0) {

                    foreach($children as $subname => $sub_child) {

                        $third = $subchild->addChild($subname,(string)$sub_child);

                        if($subchild->children()->count() > 0) {

                            foreach($sub_child as $thirdName => $third_child) {
                                $third->addChild($thirdName,(string)$third_child);
                            }
                        }
                    }
                }
            }
            break;
        }

    }

    /**
     * @param $id
     */
    public function setProductID($id) {
        $this->lastProductID = $id;
    }

    /**
     * @return int
     */
    public function getLastProductID() {
        return $this->lastProductID;
    }

    /**
     * Sets the login data for the afterbuy call
     *
     * @param $Xml\SimpleXMLElement
     * @return \SimpleXMLElement
     */
    private function setLoginData($Xml) {

        $Xml->AfterbuyGlobal->PartnerID = $this->config['partnerID'];
        $Xml->AfterbuyGlobal->PartnerPassword = $this->config['partner_password'];
        $Xml->AfterbuyGlobal->UserID = $this->config['ab_loginID'];
        $Xml->AfterbuyGlobal->UserPassword = $this->config['ab_password'];

        return $Xml;
    }

    /**
     * Create a XML file from the last response
     */
    private function createLog() {

        $handle = fopen(__DIR__ . "/../request.xml", "w");
        fwrite($handle, $this->Request->asXML());
        fclose($handle);

        $handle = fopen(__DIR__ . "/../response.xml", "w");
        fwrite($handle, $this->Response->asXML());
        fclose($handle);

    }
}