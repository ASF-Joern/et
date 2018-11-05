<?php

namespace AsfRingManager\Components;

/**
 * Class PriceCalculator
 * @package AsfRingManager\Components
 */
final class PriceCalculator {

    /**
     * @var null|Shopware()->Db()
     */
    protected $Db = null;

    /**
     * @var null
     */
    protected $Logger;

    /**
     * @var float|array
     */
    protected $width = 0.0;

    /**
     * @var float|array
     */
    protected $thickness = 0.0;

    /**
     * @var float
     */
    protected $profile = 0.0;

    /**
     * @var int
     */
    protected $alloy = 0;

    /**
     * @var string
     */
    protected $stone = "";

    /**
     * @var string
     */
    protected $color = "";

    /**
     * @var bool
     */
    protected $fromWidget = false;

    /**
     * @var int
     */
    protected $stockMarketPrice = 0;

    /**
     * @var int
     */
    protected $diamond = 0;

    /**
     * @var int
     */
    protected $zircon = 0;

    /**
     * @var float
     */
    protected $socket = 0.0;

    /**
     * @var float
     */
    protected $surcharge = 0.0;

    /**
     * @var float
     */
    protected $fee = 0.0;

    /**
     * @var float
     */
    protected $calcFactor = 0.0;

    /**
     * @var float
     */
    protected $calcFactorStone = 0.0;

    /**
     * @var int
     */
    protected $ringQuantity = 0;

    /**
     * @var bool
     */
    protected $withStones = true;

    /**
     * PriceCalculator constructor.
     * @param $db
     * @param $logger
     */
    public function __construct($db, $logger = null) {
        $this->Db = $db;
        $this->Logger = $logger;
    }

    public function setValues($catID,$width,$thickness,$profileNumber,$alloy,$stone,$color, $withStones = true, $fromWidget = false, $ringQuantity = 2) {

        $globals = $this->Db->fetchRow("SELECT * FROM asf_price_manager_globals WHERE catID = ?",$catID);

        if($profileNumber == "verlobungsring") {
            $this->setVerlobungsringValues($catID,$globals,$thickness,$alloy,$stone,$color,$fromWidget,$ringQuantity);
        } else {
            $this->setTrauringValues($catID,$globals,$width,$thickness,$profileNumber,$alloy,$stone,$color,$withStones,$fromWidget,$ringQuantity);
        }

    }

    /**
     * @return float|int
     */
    public function calculatePrice() {

        if($this->ringQuantity == 1 && !$this->fromWidget) {
            return 1000 / 1.19;
        }
        //$this->debug();

        // Breite * Stärke * 60(Durschnittsgröße) * 2
        if(is_array($this->width) && is_array($this->thickness)) {

            $width = $this->width[0] + $this->width[1];
            $thickness = $this->thickness[0] + $this->thickness[1];
            $mass = $width * $thickness * $this->profile * 60 / 2;

        } else {

            $mass = $this->width * $this->thickness * $this->profile * 60 * $this->ringQuantity;

            if(preg_match("/-\//",$this->color) && !$this->fromWidget) {
                $this->Logger->notice("Breite: $this->width Stärke: $this->thickness Profilwert: $this->profile => " . $mass);
            }
        }

        // Legierung durch 1000 * Gold/Palladium/Platin Preis pro Gramm
        $gram =  $this->alloy / 1000 * $this->stockMarketPrice;
        // Bearbeitungsgebühr und Zuschlag wird addiert
        $gram +=  $this->fee + $this->surcharge;



        if(preg_match("/-\//",$this->color) && !$this->fromWidget) {
            $this->Logger->notice("Legierung: $this->alloy Goldpreis: $this->stockMarketPrice Bearbeitungsgebühr: $this->fee Aufschlag: $this->surcharge => " . $gram);
        }

        // Kalkulationsfaktor Gold/Palladium/Platin
        $gramResult = ($mass * $gram) * $this->calcFactor;

        if(preg_match("/-\//",$this->color) && !$this->fromWidget) {
            $this->Logger->notice($mass * $gram . " Kalkulationsfaktor: $this->calcFactor  => " . $gramResult);
        }

        $this->mass = $mass;
        $this->gram = $gram;

        if($this->withStones) {

            if ($this->stone !== "Zirkonia") {

                if (!$this->fromWidget) {
                    $this->stone = substr(explode(" (", $this->stone)[1], 0, -1);
                }

                if (preg_match("/ \/ /", $this->stone)) {

                    $stoneParts = explode(" / ", $this->stone);
                    $firstStone = explode(" x ", $stoneParts[0]);
                    $secondStone = explode(" x ", $stoneParts[1]);

                    $firstCt = ((int)$firstStone[0]) * ((float)str_replace(",", ".", substr($firstStone[1], 0, -3)));
                    $secondCt = ((int)$secondStone[0]) * ((float)str_replace(",", ".", substr($secondStone[1], 0, -3)));

                    // Diamantpreis * Karat + Anzahl * Fassung und das Produkt * Kalkulationsfaktor für Steine
                    $stoneResult = ((($this->diamond * $firstCt) + ($this->diamond * $secondCt) +
                            (($firstStone[0] + $secondStone[0]) * $this->socket))) * $this->stone_calc_factor;

                } else {

                    $stoneParts = explode(" x ", $this->stone);
                    $ct = $stoneParts[0] * ((float)str_replace(",", ".", substr($stoneParts[1], 0, -3)));
                    $quantity = $stoneParts[0];

                    // Diamantpreis * Karat + Anzahl * Fassung und das Produkt * Kalkulationsfaktor für Steine
                    $stoneResult = ($this->diamond * $ct + $quantity * $this->socket) * $this->calcFactorStone;

                }

            } else {

                // Zirkonpreis * Anzahl + Fassung * Anzahl und das Produkt * Kalkulationsfaktor für Steine
                $quantity = 1;
                $stoneResult = ($this->zircon * $quantity + $quantity * $this->socket) * $this->calcFactorStone;

            }

        } else {
            $stoneResult = 0;
        }

        // Zur Rundung des Preises
        $price = (ceil(($gramResult+$stoneResult) / 5) * 5);

        if($this->fromWidget) {
            return $price;
        } else {
            return $price / 1.19;
        }

    }

    private function setVerlobungsringValues($catID,$globals,$weight,$alloy,$stone,$color,$withStones,$fromWidget,$ringQuantity) {

        $this->fromWidget = $fromWidget;
        $this->withStones = $withStones;
        $this->ringQuantity = 1;

        $this->alloy = (int)substr($alloy,0,-2);

        if($color === "Tricolorgold" || preg_match("/-\//",$color)) {

            $this->stockMarketPrice = (float)$globals['stock_market_price_gold'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_gold'];
            $this->calcFactor = (float)$globals['calculation_factor_gold'];

        } elseif(preg_match("/Palladium/",$color)) {

            $this->stockMarketPrice = (float)$globals['stock_market_price_palladium'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_palladium'];
            $this->calcFactor = (float)$globals['calculation_factor_palladium'];

        } elseif(preg_match("/Platin/",$color)) {

            $this->stockMarketPrice = (float)$globals['stock_market_price_platin'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_platin'];
            $this->calcFactor = (float)$globals['calculation_factor_platin'];

        } else {

            $this->stockMarketPrice = (float)$globals['stock_market_price_gold'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_gold'];
            $this->calcFactor = (float)$globals['calculation_factor_gold'];

        }

        $this->weight = $weight;
        $this->stone = $stone;
        $this->fromWidget = $fromWidget;
        $this->color = $color;
        $this->diamond = (int)$globals['diamond_price'];
        $this->socket = (float)$globals['socket_price'];
        $this->zircon = (int)$globals['zircon_price'];
        $this->surcharge = (float)$globals['surcharge_'.strtolower(str_replace("ß","ss",str_replace(["gold","-/"],"",$color)))];
        $this->calcFactorStone = (float)$globals['calculation_factor_stone'];

    }

    /**
     * @param $catID
     * @param $globals
     * @param $width
     * @param $thickness
     * @param $profileNumber
     * @param $alloy
     * @param $stone
     * @param $color
     * @param $withStones
     * @param $fromWidget
     * @param $ringQuantity
     */
    private function setTrauringValues($catID,$globals,$width,$thickness,$profileNumber,$alloy,$stone,$color,$withStones,$fromWidget,$ringQuantity) {

        if(!empty($profileNumber) && $profileNumber != 0) {
            $profileNumber = 4;
        }

        $this->fromWidget = $fromWidget;
        $this->withStones = $withStones;
        $this->ringQuantity = $ringQuantity;


        $this->alloy = (int)substr($alloy,0,-2);

        if($profileNumber == 0) {
            $profileNumber = 4;
        }

        if($color === "Tricolorgold" || preg_match("/-\//",$color)) {

            $this->profile = (float)$this->Db->fetchOne("SELECT `profil" . $profileNumber . "` FROM asf_price_manager_entries 
            WHERE material = ? AND alloy = ? AND catID = ?",["Gelb",$alloy,$catID]);
            $this->profile += (float)$this->Db->fetchOne("SELECT `profil" . $profileNumber . "` FROM asf_price_manager_entries 
            WHERE material = ? AND alloy = ? AND catID = ?",["Weiß",$alloy,$catID]);
            $this->profile /= 2;
            $this->stockMarketPrice = (float)$globals['stock_market_price_gold'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_gold'];
            $this->calcFactor = (float)$globals['calculation_factor_gold'];

        } elseif(preg_match("/Palladium/",$color)) {

            $this->profile = $this->Db->fetchOne("SELECT `profil" . $profileNumber . "` FROM asf_price_manager_entries 
            WHERE material = ? AND alloy = ? AND catID = ?",["Palladium",$alloy,$catID]);
            $this->stockMarketPrice = (float)$globals['stock_market_price_palladium'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_palladium'];
            $this->calcFactor = (float)$globals['calculation_factor_palladium'];

        } elseif(preg_match("/Platin/",$color)) {

            $this->profile = $this->Db->fetchOne("SELECT `profil" . $profileNumber . "` FROM asf_price_manager_entries 
            WHERE material = ? AND alloy = ? AND catID = ?",["Platin",$alloy,$catID]);
            $this->stockMarketPrice = (float)$globals['stock_market_price_platin'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_platin'];
            $this->calcFactor = (float)$globals['calculation_factor_platin'];

        } else {

            $this->profile = $this->Db->fetchOne("SELECT `profil" . $profileNumber . "` FROM asf_price_manager_entries 
            WHERE material = ? AND alloy = ? AND catID = ?",[str_replace("gold", "", $color),$alloy,$catID]);
            $this->stockMarketPrice = (float)$globals['stock_market_price_gold'];
            $this->fee = (float)$globals['handling_fee_'.$this->alloy.'_gold'];
            $this->calcFactor = (float)$globals['calculation_factor_gold'];

        }

        if(is_array($width) && is_array($thickness)) {
            $this->width = $width;
            $this->thickness = $thickness;
        } else {
            $this->width = (float)$width;
            $this->thickness = (float)$thickness;
        }

        $this->stone = $stone;
        $this->color = $color;
        $this->diamond = (int)$globals['diamond_price'];
        $this->socket = (float)$globals['socket_price'];
        $this->zircon = (int)$globals['zircon_price'];
        $this->surcharge = (float)$globals['surcharge_'.strtolower(str_replace("ß","ss",str_replace(["gold","-/"],"",$color)))];
        $this->calcFactorStone = (float)$globals['calculation_factor_stone'];

    }

    public function calculate($catID,$womanWidth,$manWidth,$womanThickness,$manThickness,$profileNumber,$alloy,$stone,
                              $color,$withStones,$fromWidget,$ringQuantity) {

        $globals = $this->Db->fetchRow("SELECT * FROM asf_price_manager_globals WHERE catID = ?",$catID);
        (float)$this->Db->fetchOne("SELECT `profil" . $profileNumber . "` FROM asf_price_manager_entries WHERE material = ? AND alloy = ? AND catID = ?",["Gelb",$alloy,$catID]);
        $wMass = $womanWidth * $womanThickness * 60 * $globals;
        $mMass;



    }

    private function debug() {

        unset($this->Db);

        echo "<pre>";
        var_dump($this);
        die("</pre>");
    }

}