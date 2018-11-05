<?php

class Shopware_Controllers_Widgets_AsfAfterbuyDownloadManager extends Enlight_Controller_Action
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $file = '';

    /**
     * @var string
     */
    private $link = '';

    /**
     * @var Components\Afterbuy
     */
    private $Afterbuy;

    /**
     * The plugin config is needed in this controller to get a order from afterbuy do build engraving files
     */
    public function init() {
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('AsfAfterbuy');
    }

    /**
     * Gets the order from Afterbuy by orderID in Afterbuy
     */
    public function preDispatch() {

        if($_SERVER['REMOTE_ADDR'] !== "62.143.214.39") {
            die();
        }

        $nr = $this->Request()->getParam("nr", null);

        if(empty($nr)) {
            die("<h1>Bitte eine OrderID from Afterbuy angeben</h1>");
        }

        $this->Afterbuy = new AsfAfterbuy\Components\Afterbuy($this->config);
        $this->Afterbuy->setRequest("GetSoldItems",250);
        $this->Afterbuy->setFilter("UserDefinedFlag", 16018);
        $this->Afterbuy->setResponse();

    }

    /**
     * Started the download if there is a .emx file in the root directory from the AsfAfterbuy plugin
     */
    public function postDispatch()
    {

        if ($handle = opendir(__DIR__ . "/../../engraving/")) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry !== "." && $entry !== ".." && substr($entry,-4) === ".emx") {
                    $file = __DIR__ . "/../../engraving/".$entry;
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=".$entry);
                    header("Content-Type: application/zip");
                    header("Content-Transfer-Encoding: binary");

                    // read the file from disk
                    readfile($file);
                    unlink($file);
                    die();
                } else {
                }
            }
            closedir($handle);
        }

        die();

    }

    private function createObject($result, $mode = 0) {

        $ObjectStore = new SimpleXMLElement(__DIR__ . '/../../Resources/xml/ObjectStore.xml', null, true);

        $objCounter = 0;

        if($mode === 0) {
            $gender = $result['woman'];
        } else {
            $gender = $result['man'];
            $result['ct'] = '';
        }

        $gender['alloy'] = $result['alloy'];
        $gender['ct'] = $result['ct'];

        foreach($ObjectStore as $name => $Object) {

            if($name === "Object") {

                switch($objCounter) {
                    case 0: $Object = $this->setGeneralObject($Object, $gender);
                        break;
                    case 3: $Object = $this->setAlloyObject($Object, $gender);
                        break;
                    case 4: $Object = $this->setLogoObject($Object, $gender);
                        break;
                    case 5: $Object = $this->setEngravingFont($Object, $gender);
                        break;
                    case 6: $Object = $this->setEngravingObject($Object, $gender);
                        break;
                    case 8: $Object = $this->setAlloySettings($Object, $gender);
                        break;
                }

                $objCounter++;

            }

        }

        return $ObjectStore;

    }

    private function getWomanAndMan($description) {

        $blocks = explode(":", $description);
        $block = explode(" x ", $blocks[0])[1];
        preg_match("/- \d\d\d\d/", $block, $matches);
        $alloy = explode(" ", substr($block, 0, strpos($block, $matches[0])))[2];

        $womanEngraving = str_replace("❧", " DH ", (trim($blocks[1])));
        $manEngraving = str_replace("❧", " DH ", (trim($blocks[2])));

        $womanEngraving = preg_replace("/\s\s/","", $womanEngraving, -1);
        $manEngraving = preg_replace("/\s\s/","", $manEngraving, -1);

        $end = (strpos($manEngraving, "br")-1);
        $manEngraving = substr($manEngraving, 0, $end);
        $end = (strpos($womanEngraving, "br")-1);
        $womanEngraving = substr($womanEngraving, 0, $end);

        $womanDiameter = str_replace("m", "", explode(")", str_replace(",", ".", substr(explode("Ø ", $blocks[3])[1], 0,5)))[0]);
        $manDiameter = str_replace("m", "", explode(")", str_replace(",", ".", substr(explode("Ø ", $blocks[4])[1], 0,5)))[0]);

        $strAndWidth = explode("/", explode("D/H:", $description)[1]);

        $womanWidth = str_replace("mm","", explode("-", $strAndWidth[0])[0]);
        $womanStr = str_replace("mm","", explode("-", $strAndWidth[0])[1]);

        $manWidth = str_replace("mm","", explode("-", $strAndWidth[0])[0]);
        $manStr = substr(explode("-", $strAndWidth[0])[1],0,3);

        $result = ["alloy" => $alloy, "woman" => [$womanEngraving,$womanDiameter,$womanWidth,$womanStr], "man" => [$manEngraving,$manDiameter,$manWidth,$manStr]];

        return $result;

    }

    private function getWoman($description) {

        $blocks = explode(":", $description);
        $block = explode(" x ", $blocks[0])[1];
        preg_match("/- \d\d\d\d/", $block, $matches);
        $alloy = explode(" ", substr($block, 0, strpos($block, $matches[0])))[2];

        $womanEngraving = str_replace("❧", " DH ", (trim($blocks[1])));

        $womanEngraving = preg_replace("/\s\s/","", $womanEngraving, -1);

        $end = (strpos($womanEngraving, "br")-1);
        $womanEngraving = substr($womanEngraving, 0, $end);

        $womanDiameter = str_replace("m", "", explode(")", str_replace(",", ".", substr(explode("Ø ", $blocks[2])[1], 0,5)))[0]);

        $strAndWidth = explode("/", explode("D:", $description)[1]);

        $womanWidth = str_replace("mm","", explode("-", $strAndWidth[0])[0]);
        $womanStr = str_replace("mm","", explode("-", $strAndWidth[0])[1]);

        $result = ["alloy" => $alloy, "woman" => [$womanEngraving,$womanDiameter,$womanWidth,$womanStr]];

        return $result;

    }

    private function getMan($description) {

        $blocks = explode(":", $description);
        $block = explode(" x ", $blocks[0])[1];
        preg_match("/- \d\d\d\d/", $block, $matches);
        $alloy = explode(" ", substr($block, 0, strpos($block, $matches[0])))[2];

        $manEngraving = str_replace("❧", " DH ", (trim($blocks[1])));

        $manEngraving = preg_replace("/\s\s/","", $manEngraving, -1);

        $end = (strpos($manEngraving, "br")-1);
        $manEngraving = substr($manEngraving, 0, $end);

        $manDiameter = str_replace("m", "", explode(")", str_replace(",", ".", substr(explode("Ø ", $blocks[2])[1], 0,5)))[0]);

        $strAndWidth = explode("/", explode("D:", $description)[1]);

        $manWidth = str_replace("mm","", explode("-", $strAndWidth[0])[0]);
        $manStr = str_replace("mm","", explode("-", $strAndWidth[0])[1]);

        $result = ["alloy" => $alloy, "man" => [$manEngraving,$manDiameter,$manWidth,$manStr]];

        return $result;

    }

    /**
     * @param $Object
     * @param $result
     * @return mixed
     */
    private function setGeneralObject($Object, $result) {

        foreach($Object as $name => $elem) {

            if((string)$elem->attributes()["name"] === "SurfaceType") {
                //$elem[0] = 2;
            } elseif((string)$elem->attributes()["name"] === "Diameter") {
                $elem[0] = $result[1];
            } elseif((string)$elem->attributes()["name"] === "Width") {
                $elem[0] = $result[2];
            } elseif((string)$elem->attributes()["name"] === "Circumference") {
                $elem[0] = $result[1] * 3.14159265359;
            }

        }

        return $Object;

    }

    private function setEngravingObject($Object, $result) {

        foreach($Object as $name => $elem) {

            if((string)$elem->attributes()["name"] === "Name") {
                // 3.14159265359
            } elseif((string)$elem->attributes()["name"] === "Y") {
                $elem[0] = $result[2] / 2;
            } elseif((string)$elem->attributes()["name"] === "Text") {
                $elem[0] = $result[0];
            } elseif((string)$elem->attributes()["name"] === "Width") {
                $elem[0] = $result[2];
            } elseif((string)$elem->attributes()["name"] === "X") {
                $elem[0] = $result[1] * 3.14159265359 / 2;
            }

        }

        return $Object;

    }

    private function setAlloyObject($Object, $result) {

        $ct = !empty($result['ct']) ? " / " . $result['ct'] : "";

        foreach($Object as $name => $elem) {

            if((string)$elem->attributes()["name"] === "Name") {
                // 3.14159265359
            } elseif((string)$elem->attributes()["name"] === "Y") {
                $elem[0] = $result[2] / 2 - 1;
            } elseif((string)$elem->attributes()["name"] === "Text") {
                $elem[0] = $result['alloy'] . $ct;
            } elseif((string)$elem->attributes()["name"] === "X") {
                $elem[0] = 0;
            }

        }

        return $Object;

    }

    private function setLogoObject($Object, $result) {

        foreach($Object as $name => $elem) {

            if((string)$elem->attributes()["name"] === "Name") {
                // 3.14159265359
            } elseif((string)$elem->attributes()["name"] === "Y") {
                $elem[0] = $result[2] / 2 + 0.6;
            } elseif((string)$elem->attributes()["name"] === "X") {
                $elem[0] = 0;
            }

        }

        return $Object;

    }

    private function setAlloySettings($Object, $result) {

        return $Object;
    }

    /**
     * @todo cause actually we dont have this parameter in the orders
     * @param $Object
     * @param $result
     * @return SimpleXMLElement
     */
    private function setEngravingFont($Object, $result) {

        foreach($Object as $name => $elem) {

            if((string)$elem->attributes()["name"] === "Name") {
                // @todo
            }
        }

        return $Object;

    }

    /**
     * Here we get the details from Afterbuy feedback link and create a file
     *
     * Functions implimented:
     *  in one order with one article:
     *      D/H yes
     *      D yes
     *      H yes
     *  in one order with two articles:
     *      D/H no
     */
    public function indexAction()
    {
        $this->link = $this->Afterbuy->getOrderLinkForDownload();
        $this->file = file_get_contents($this->link);

        $ordernumber = explode(">", explode("</a>", explode('Artikelnummer:</td>', $this->file)[1])[0])[2];

        $parts = explode('<td class="txtRight txtTop">Beschreibung:</td>', $this->file);
        $description = explode("</td>", explode('<td class="txtRight txtTop">Beschreibung:</td>', $this->file)[1])[0];

        $attributes = explode('br',$parts[1]);
        $stone = true;

        $realAttributes = [];

        foreach($attributes as &$attribute) {
            $attribute = str_replace(["/>",">","<","\n"],["","","",""],trim(strip_tags($attribute)));

            if(preg_match("/\w+-Größe/")) {
                $key = trim(explode(":", $attribute)[0]);
                $value = trim(explode(":", $attribute)[1]);
            }

            if(preg_match("/\w+-Gravur/")) {
                $key = trim(explode(":", $attribute)[0]);
                $value = trim(explode(":", $attribute)[1]);
            }

            if(preg_match("/\w+gold/")) {
                $key = trim(explode(":", $attribute)[0]);
                $value = trim(explode(":", $attribute)[1]);
            }

        }

        // Finding the correct material
        if(preg_match("/gold/", $attributes[0])) {
            $ch_symbol = "AU";
        } elseif(preg_match("/Silber/", $attributes[0])) {
            $ch_symbol = "AG";
        } elseif(preg_match("/Platin/", $attributes[0])) {
            $ch_symbol = "PT";
        } elseif(preg_match("/Palladium/", $attributes[0])) {
            $ch_symbol = "PD";
        } else {
            $ch_symbol = '';
        }

        if(preg_match("/Ohne Stein\/e/", $description)) {
            $stone = false;
        }

        die(var_dump($attributes));

        // The needed invoice number for the barcode scanner
        $invoiceNumber = $this->Afterbuy->getInvoiceNumberForDownload();

        // This second Afterbuy call is needed to get ct
        $this->Afterbuy->setRequest("GetShopProducts");
        $this->Afterbuy->setFilter("Anr", $ordernumber);
        $this->Afterbuy->setResponse();

        $ct = explode(" ", $this->Afterbuy->getArticleData()[0]['FreeValue5'])[0];

        // If we count 3 parts here we have two articles in on order
        if(count($parts) === 3) {
            // @todo
        } else {

            if (preg_match("/D\/H/", $description)) {

                $result = $this->getWomanAndMan($description);
                if ($stone) {
                    $result['ct'] = $ct;
                } else {
                    $result['ct'] = '';
                }

                $result['alloy'] = substr($result['alloy'], 0, 3) . $ch_symbol;

                $woman = $this->createObject($result);
                $man = $this->createObject($result, 1);

                $handle = fopen(__DIR__ . "/../../engraving/ET" . $invoiceNumber . "D.emx", "wb");
                fwrite($handle, $woman->asXML());
                fclose($handle);

                $handle = fopen(__DIR__ . "/../../engraving/ET" . $invoiceNumber . "H.emx", "wb");
                fwrite($handle, $man->asXML());
                fclose($handle);

            } elseif (preg_match("/D/", $description)) {

                $result = $this->getWoman($description);

                if ($stone) {
                    $result['ct'] = $ct;
                } else {
                    $result['ct'] = '';
                }

                $result['alloy'] = substr($result['alloy'], 0, 3) . $ch_symbol;

                $woman = $this->createObject($result);

                $handle = fopen(__DIR__ . "/../../engraving/ET" . $invoiceNumber . "D.emx", "wb");
                fwrite($handle, $woman->asXML());
                fclose($handle);

            } else {
                $result = $this->getMan($description);

                $result = $this->getWoman($description);

                if ($stone) {
                    $result['ct'] = $ct;
                } else {
                    $result['ct'] = '';
                }

                $result['alloy'] = substr($result['alloy'], 0, 3) . $ch_symbol;

                $woman = $this->createObject($result);

                $handle = fopen(__DIR__ . "/../../engraving/ET" . $invoiceNumber . "H.emx", "wb");
                fwrite($handle, $woman->asXML());
                fclose($handle);

            }

        }

    }
}
