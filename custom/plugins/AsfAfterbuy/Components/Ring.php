<?php

namespace AsfAfterbuy\Components;

/**
 * Class Ring
 * @package AsfAfterbuy\Components
 */
abstract class Ring {

    /**
     * @var array
     */
    protected $articleData = [];

    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var int
     */
    protected $supplierID = 0;

    /**
     * @var string 
     */
    protected $supplierName = "";
    
    /**
     * @var string
     */
    protected $articleName = "";

    /**
     * @var string
     */
    protected $description = "";

    /**
     * @var string
     */
    protected $description_long = "";

    /**
     * @var string
     */
    protected $shippingtime = "";

    /**
     * @var string
     */
    protected $attr4 = "";

    /**
     * @var string
     */
    protected $attr5 = "";

    /**
     * @var string
     */
    protected $attr6 = "";

    /**
     * @var string
     */
    protected $attr7 = "";

    /**
     * @var string
     */
    protected $attr8 = "";

    /**
     * @var string
     */
    protected $attr9 = "";

    /**
     * @var string
     */
    protected $attr10 = "";

    /**
     * @var string
     */
    protected $attr11 = "";

    /**
     * @var string
     */
    protected $attr12 = "";

    /**
     * @var string
     */
    protected $attr13 = "";

    /**
     * @var string
     */
    protected $ordernumber = "";

    /**
     * @var float
     */
    protected $price = 0.0;

    /**
     * @var string
     */
    protected $imageHash = "";

    /**
     * @var string
     */
    protected $imageLink = "";

    /**
     * @var string 
     */
    protected $imageOldLink = "";

    /**
     * @param array $data
     */
    public function setArticleData($data) {
        $this->articleData = $data;
    }

    /**
     * @return void
     */
    abstract function defaultMapping();

    /**
     * @return void
     */
    abstract function configMapping();

    /**
     * @return void
     */
    abstract function createArticlesData();

    /**
     * @return void
     */
    abstract function createArticlesDetails();

    /**
     * @return void
     */
    abstract function createArticlesAttributes();

    /**
     * @return void
     */
    abstract function createArticlesPrices();

    /**
     * @return mixed
     */
    abstract function createCustomProductsEntry();

    /**
     * @param $ordernumber
     * @param $msg
     */
    protected function setLogEntry($ordernumber, $msg) {
        "";
    }

    /**
     * @return array
     */
    protected function getLog() {
       return "";
    }

    /**
     * @param $id
     */
    protected function setId($id) {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $detailsId
     */
    protected function setDetailsId($detailsId) {
        $this->detailsId = $detailsId;
    }

    /**
     * @return mixed
     */
    public function getDetailsId() {
        return $this->detailsId;
    }

    protected function url_exists($url) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    /**
     * @param $str
     * @return mixed
     */
    protected function cleanString($str) {
        return str_replace(["Ä","ä","Ö","ö","Ü","ü","ß","é"],["Ae","ae","Oe","oe","Ue","ue","ss","e"],$str);
    }

}