<?php

namespace AsfAfterbuy\Traits;

/**
 * Trait Calculator
 * @package AsfAfterbuy\Traits
 */
trait Calculator {

    /**
     * @var string
     */
    public $clarity = 'g-si';

    /**
     * @var string
     */
    public $log = "";

    /**
     * @var int
     */
    public $size = 54;

    /**
     * @param $stone
     * @param $frontend
     * @return string
     */
    public function identifyStone($stone,$frontend = false) {

        if($frontend) {

            if(preg_match("/ohne Steinbesatz/",$stone)) {
                return false;
            } elseif(preg_match("/Zirkonia/",$stone)) {
                return "zircon";
            } elseif(preg_match("/Tw\/Si/i",$stone)) {
                return "trauringe";
            } elseif(preg_match("/\d,\d+ct. \/ Ø \d,\dmm/",$stone)) {
                return "verlobungsring";
            } elseif(preg_match("/\d,\d+ct. \/ \dmm x \dmm/",$stone) || preg_match("/\d,\d+ct. \/ \d,\dmm x \d,\dmm/",$stone)) {
                return "verlobungsring";
            } else {
                return false;
            }

        } else {

            if(preg_match("/ohne Steinbesatz/",$stone)) {
                return "calculateMaterial";
            } elseif(preg_match("/Zirkonia/",$stone)) {
                return "calculateZircon";
            } elseif(preg_match("/Tw\/Si/i",$stone)) {
                return "calculateTrauringe";
            } elseif(preg_match("/\d,\d+ct. \/ Ø \d,\dmm/",$stone)) {
                return "calculateVerlobungsring";
            } elseif(preg_match("/\d,\d+ct. \/ \dmm x \dmm/",$stone) || preg_match("/\d,\d+ct. \/ \d,\dmm x \d,\dmm/",$stone)) {
                return "calculateVerlobungsring";
            } else {
                return $stone;
            }

        }

    }

    /**
     * @param $articleName
     * @return bool
     */
    public function isPartnerringe($articleName) {

        if(preg_match("/Partnerringe/",$articleName) || preg_match("/Freundschaftsringe/",$articleName)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $stone
     * @param $quantity
     * @return float|int|mixed
     */
    public function getAmountOfCarat($stone,$quantity = 1) {

        if(preg_match("/ohne Steinbesatz/",$stone)) {
            return 0;
        } elseif(preg_match("/Zirkonia/",$stone)) {
            return -1;
        } elseif(preg_match("/Tw\/Si/i",$stone)) {
            return str_replace(",",".",explode("ct.",$stone)[0]);
        } elseif(preg_match_all("/\d,\d+ct. \/ Ø \d,\dmm/",$stone,$matches)) {

            $ct = 0;

            if(preg_match("/ + /",$quantity)) {
                $quantities = explode(" + ",$quantity);
            } else {
                $quantities = [$quantity];
            }

            foreach($matches[0] as $key => $match) {
                $ct += $quantities[$key] * (float)str_replace(",",".",explode("ct.",$match)[0]);
            }

            return $ct;

        } elseif(preg_match_all("/\d,\d+ct. \/ \dmm x \dmm/",$stone,$matches) || preg_match_all("/\d,\d+ct. \/ \d,\dmm x \d,\dmm/",$stone,$matches)) {

            $ct = 0;

            if(preg_match("/ + /",$quantity)) {
                $quantities = explode(" + ",$quantity);
            } else {
                $quantities = [$quantity];
            }

            foreach($matches[0] as $key => $match) {
                $ct += $quantities[$key] * (float)explode("x ",str_replace(",",".",explode("ct.",$match)[0]))[0];
            }

            return $ct;

        } else {
            return 0;
        }

    }

    /**
     * @param $stone
     * @return string
     */
    public function getSeparatedStoneQuantity($stone) {

        if(preg_match("/Tw\/Si/i",$stone)) {

            if(preg_match_all("/\d+ x \d,\d+ct./",$stone,$matches)) {
                return implode("|",$matches[0]);
            }

        }

        return $stone;

    }

    /**
     * @param $stoneParts
     * @return int
     */
    public function getAmountOfStones($stoneParts) {

        $number = 0;

        if(preg_match("/|/",$stoneParts)) {

            $parts = explode("|",$stoneParts);
            foreach($parts as $part) {
                $number += (int)explode(" ",$part)[0];
            }

        } else {
            $number = explode(" ",$stoneParts)[0];
        }

        return $number;

    }

    /**
     * @param $area
     * @param $material
     * @param $alloy
     * @param $profile
     * @param $stone
     * @param $quantity
     * @return array
     */
    public function calculateTrauringe($area,$material,$alloy,$profile,$stone,$quantity) {

        $this->size = 60;
        $gramPrice = $this->calculateMaterial($area,$material,$alloy,$profile,$stone);

        $stonePrice = $this->calculateStone($this->getAmountOfCarat($stone),$quantity);
        $result = $gramPrice+$stonePrice;

        return [$gramPrice, $stonePrice, ceil($result / 5) * 5 , ((ceil($result / 5) * 5)  / 1.19), $result];

    }

    /**
     * @param $area
     * @param $material
     * @param $alloy
     * @param $profile
     * @param $stone
     * @param $quantity
     * @return array
     */
    public function calculateZircon($area,$material,$alloy,$profile,$stone,$quantity) {

        $gramPrice = $this->calculateMaterial($area,$material,$alloy,$profile,$stone);
        $stonePrice = $this->getZircon();
        $result = $gramPrice+$stonePrice;

        return [$gramPrice, $stonePrice, ceil($result / 5) * 5 , ((ceil($result / 5) * 5)  / 1.19),$result];

    }

    /**
     * @param $area
     * @param $material
     * @param $alloy
     * @param $stone
     * @return array
     */
    public function calculateVerlobungsring($area,$material,$alloy,$stone,$quantity,$refinement) {


        $ekGramPrice = ($area * (int)substr($alloy,0,3) / 1000) * $this->getStockMarketPrice($material) + $this->getSurcharge($material)
            + $this->getHandlingFee($material,$alloy);

        $gramPrice = $ekGramPrice * $this->getCalculationFactor($material);

        if(preg_match("/\+/",$stone)) {
            $stoneParts = explode(" + ",$stone);
            $quantityParts = explode("+",str_replace(" ","",$quantity));

            $mainStone = $this->calculateVrStone($this->getAmountOfCarat($stoneParts[0]),$quantityParts[0],$refinement);
            $sideStones = $this->calculateVrStone($this->getAmountOfCarat($stoneParts[1]),$quantityParts[1],$refinement);

            $stonePrice = $mainStone + $sideStones;

        } else {
            $stonePrice = $this->calculateVrStone($this->getAmountOfCarat($stone),$quantity,$refinement);
        }

        $result = $gramPrice+$stonePrice;

        return [$gramPrice, $stonePrice, ceil($result / 5) * 5 , ((ceil($result / 5) * 5)  / 1.19),$result];

    }

    /**
     * @param $area (width+width * thickness+thickness / 2)
     * @param $material
     * @param $alloy
     * @param $profile
     * @param $stone
     * @return float|int
     */
    public function calculateMaterial($area,$material,$alloy,$profile,$stone) {

        if(!is_float($profile) && is_int($profile)) {
            $profile = $this->getProfile($material,$alloy,$profile);
        } else {
            $profile = $this->getProfile($material,$alloy,substr($profile,-1));
        }

        if(empty($this->size) || $this->catID == "64") {
            $this->size = 60;
        }

        $mass = $area * $profile * $this->size;
        $gram = (int)substr($alloy,0,3) / 1000 * $this->getStockMarketPrice($material) + $this->getSurcharge($material)
            + $this->getHandlingFee($material,$alloy);
        $gramPrice = $mass * $gram * $this->getCalculationFactor($material);

        return $gramPrice;

    }

    /**
     * @param $area
     * @param $material
     * @param $alloy
     * @param $profile
     * @param $stone
     * @param $quantity
     * @return array
     */
    public function calculateMemoirering($area,$material,$alloy,$profile,$stone,$quantity,$size) {

        $this->size = $size;
        $this->catID = 64;
        if($material === null) {
            return null;
        }

        if($material !== "Silber") {
            $gramPrice = $this->calculateMaterial($area,$material,$alloy,$profile,$stone);
        } else {
            $gramPrice = 50;
        }

        if($this->clarity === "zirkonia") {
            if($stone == "Halbkranz") {
                $stonePrice = 70;
            } else {
                $stonePrice = 140;
            }
        } else {
            $stonePrice = $this->calculateVrStone($stone,$quantity,"Brillant");
        }


        $result = $gramPrice+$stonePrice;

        return [$gramPrice, $stonePrice, ceil($result / 5) * 5 , ((ceil($result / 5) * 5)  / 1.19), $result];

    }

    /**
 * @param $ct
 * @param $quantity
 * @return float|int
 */
    public function calculateStone($ct,$quantity) {

        if($ct === -1) {
            return ($this->getZircon());
        } else {
            return ($this->getDiamond() * $ct + $quantity * $this->getSocket()) * $this->getCalculationFactorStone();
        }

    }

    /**
     * @param $ct
     * @param $quantity
     * @param $refinement
     * @return float|int
     */
    public function calculateVrStone($ct,$quantity,$refinement) {

        $table = $this->getVrTable($refinement);

        if(empty($this->clarity)) {
            $this->clarity = "g-si";
        }

        foreach($table as $entry) {

            if((float)str_replace(",",".",$entry['carat']) == $ct) {
                return ($quantity * $this->getSocket() + ($quantity * $ct * $entry[$this->clarity])) * $this->getCalculationFactorStone();
            }

            $newEntry = (float)str_replace(",",".",$entry['carat']);
            if($newEntry < $ct) {
                $last = $entry[$this->clarity];
            }

        }

        return ($quantity * $this->getSocket() + ($ct * $last)) * $this->getCalculationFactorStone();

    }

    /**
     * @param $refinement
     * @return mixed
     */
    private function getVrTable($refinement) {

        if(preg_match("/Brillant/",$refinement)) {
            return $this->getBrillant();
        } else {
            return $this->getPrincess();
        }

    }

    /**
     * @return mixed
     */
    private function getBrillant() {
        return Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_brillant");
    }

    private function getPrincess() {
        return Shopware()->Db()->fetchAll("SELECT * FROM asf_price_manager_princess");
    }

    /**
     * @return float
     */
    private function getDiamond() {
        return (float)Shopware()->Db()->fetchOne("SELECT diamond_price FROM `asf_price_manager_globals` WHERE catID = ?", $this->catID);
    }

    /**
     * @return float
     */
    private function getCalculationFactorStone() {
        return (float)Shopware()->Db()->fetchOne("SELECT calculation_factor_stone FROM `asf_price_manager_globals` WHERE catID = ?", $this->catID);
    }

    /**
     * @return float
     */
    private function getZircon() {
        return (float)Shopware()->Db()->fetchOne("SELECT zircon_price FROM `asf_price_manager_globals` WHERE catID = ?", $this->catID);
    }

    /**
     * @return float
     */
    private function getSocket() {
        return (float)Shopware()->Db()->fetchOne("SELECT socket_price FROM `asf_price_manager_globals` WHERE catID = ?", $this->catID);
    }

    /**
     * @param $material
     * @param $alloy
     * @param $profile
     * @return mixed
     */
    private function getProfile($material,$alloy,$profile) {

        if($profile == 0) {
            $profile = 4;
        }

        if(preg_match("/-\//",$material)) {

            $materials = explode("-/",$material);

            $profiles = Shopware()->Db()->fetchAll("SELECT profil".$profile." FROM `asf_price_manager_entries` 
            WHERE alloy = ? AND catID = ? AND (material = ? OR material = ?)", [$alloy,$this->catID,$materials[0],str_replace("gold","",$materials[1])]);

            return ((array_shift($profiles[0]) + array_shift($profiles[1])) / 2);

        } else {
            $material = str_replace("gold","",$material);

            if($material === "Tricolor") {

                $profiles = Shopware()->Db()->fetchAll("SELECT profil".$profile." FROM `asf_price_manager_entries` 
                WHERE alloy = ? AND catID = ? AND (material = ? OR material = ?)", [$alloy,$this->catID,"Gelb","Weiß"]);

                return ((array_shift($profiles[0]) + array_shift($profiles[1])) / 2);

            } else {
                return Shopware()->Db()->fetchOne("SELECT profil".$profile." FROM `asf_price_manager_entries`
                WHERE material = ? AND alloy = ? AND catID = ?", [$material,$alloy,$this->catID]);
            }

        }
    }

    /**
     * @param $material
     * @return float
     */
    private function getStockMarketPrice($material) {
        return (float)Shopware()->Db()->fetchOne("SELECT stock_market_price_".$this->identifyMaterial($material). " FROM `asf_price_manager_globals`
        WHERE catID = ?",$this->catID);
    }

    /**
     * @param $material
     * @return string
     */
    private function identifyMaterial($material) {

        if(preg_match("/Palladium/",$material)) {
            return "palladium";
        } elseif(preg_match("/Platin/",$material)) {
            return "platin";
        } elseif(preg_match("/Silber/",$material)) {
            return "silber";
        } else {
            return "gold";
        }

    }

    /**
     * @param $material
     * @return float
     */
    private function getSurcharge($material) {

        if(empty($material)) {
            return 0;
        }

        if(preg_match("/-\//",$material)) {

            $partOne = str_replace(["gold","-/","ß","é"],["","","ss","e"],strtolower(explode("-/",$material)[0]));
            $partTwo = str_replace(["gold","-/","ß","é"],["","","ss","e"],strtolower(explode("-/",$material)[1]));

            if($partOne == "weiss") {
                $concat = $partTwo.$partOne;
            } else {
                $concat = $partOne.$partTwo;
            }

            $result = (float)Shopware()->Db()->fetchOne("SELECT surcharge_".$concat."
            FROM `asf_price_manager_globals` WHERE catID = ?",$this->catID);

            return $result;

        } else {
            return (float)Shopware()->Db()->fetchOne("SELECT surcharge_".str_replace(["gold","-/","ß","é"],["","","ss","e"],strtolower($material))."
            FROM `asf_price_manager_globals` WHERE catID = ?",$this->catID);
        }

    }

    /**
     * @param $material
     * @param $alloy
     * @return float
     */
    private function getHandlingFee($material,$alloy) {
        return (float)Shopware()->Db()->fetchOne("SELECT handling_fee_".substr($alloy,0,3)."_".$this->identifyMaterial($material)."
        FROM `asf_price_manager_globals` WHERE catID = ?",$this->catID);
    }

    /**
     * @param $material
     * @return float
     */
    private function getCalculationFactor($material) {
        return (float)Shopware()->Db()->fetchOne("SELECT calculation_factor_".$this->identifyMaterial($material)."
        FROM `asf_price_manager_globals` WHERE catID = ?",$this->catID);
    }


}