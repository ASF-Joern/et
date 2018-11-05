<?php

namespace AsfRingManager\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs as ActionEventArgs;
use Shopware\Bundle\SearchBundle\FacetResult\MediaListItem;

class Checkout implements SubscriberInterface
{

    /**
     *
     */
    use \AsfAfterbuy\Traits\Calculator;

    /**
     * @var
     */
    private $catID;

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
            'Shopware_Modules_Basket_UpdateArticle_FilterSqlDefault' => 'UpdateArticleFilterSqlDefault',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onPostDispatchCheckout',
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
     * @param \Enlight_Event_EventArgs $args
     * @return mixed
     */
    public function UpdateArticleFilterSqlDefault(\Enlight_Event_EventArgs $args) {

        $result = Shopware()->Db()->fetchRow("SELECT `configuration`,articlename,articleID FROM `s_order_basket_attributes` a
            LEFT JOIN `s_plugin_custom_products_configuration_hash` b 
            ON a.swag_custom_products_configuration_hash = b.hash
            LEFT JOIN `s_order_basket` c 
            ON a.basketID = c.id
            WHERE basketID = ?", $args->getId());

        $articleID = $result['articleID'];
        $config = [];

        if(preg_match("/Partnerringe/", $result['articlename'])) {
            return $args->setReturn($args->getReturn());

        }

        foreach(json_decode($result['configuration']) as $id => $values) {

            $name = Shopware()->Db()->fetchOne("SELECT `name` FROM `s_plugin_custom_products_option` WHERE id = ?",$id);
            $valueID = array_shift($values);
            $value = Shopware()->Db()->fetchOne("SELECT `name` FROM `s_plugin_custom_products_value` WHERE id = ?",$valueID);

            if(empty($value)) {
                $value = str_replace("mm", "", $valueID);
            }

            $config[$name] = $value;

        }

        // Workaround for BUG: quantity 2 if we buy a Verlobungsring
        if(preg_match("/Verlobungsring/", $result['articlename'])) {
            Shopware()->Db()->query("UPDATE s_order_basket SET quantity = 1 WHERE id = ?",$args->getId());
        }

        $this->catID = Shopware()->Db()->fetchOne("SELECT parent FROM s_categories WHERE id = ?",
            Shopware()->Db()->fetchOne("SELECT categoryID FROM s_articles_categories WHERE articleID = ?",$result['articleID']));


        if(preg_match("/Memoirering/",$result['articlename'])) {

            $article = Shopware()->Db()->fetchRow("SELECT width, height, attr7 as alloy, attr13 as material,attr14 FROM s_articles_attributes a LEFT JOIN 
                s_articles_details b ON a.articleID = b.articleID WHERE a.articleID = ?",$articleID);

            $size = substr($config['Ring-Größe'],0,2);
            $this->clarity = strtolower(str_replace("/","-",$config['Reinheit']));

            $stone = explode(" / ",$config['Steinbesatz'])[0];

            $outerDia = ((int)substr(trim($size),0,2) / pi() + ((((float)$article['height']) * 2))) * pi();

            $factor = 1;

            if(substr($article['attr14'],0,1) === "V") {
                if(substr($article['attr14'],1,1) === "H") {
                    $factor = 2;
                }
                $gap = 0.2;
            } else {
                if(preg_match("/Kr/",$article['attr14'])) {
                    if(substr($article['attr14'],2,1) === "H") {
                        $factor = 2;
                    }
                    $gap = 0.2;
                } else {
                    if(substr($article['attr14'],1,1) === "H") {
                        $factor = 2;
                    }
                    $gap = 0;
                }
            }

            $stoneDiameter = Shopware()->Db()->fetchOne("SELECT diameter FROM asf_price_manager_memoire WHERE carat = ?",
                str_replace([",","ct."],[".",""],$stone));

            $stones = floor(floor(($outerDia) / ($stoneDiameter + $gap)) / $factor);

            $article['weight'] = $stones * str_replace(",",".",$article['width']);
            $_SESSION[$articleID] = $stones;

            $result = $this->calculateMemoirering($article['width']*$article['height'], $article['material'], $article['alloy'],
                (int)substr($config['Profil'],6,1), str_replace([",","ct."],[".",""],$stone),$stones,(int)$size);

            $data[] = $args->getQuantity();
            $data[] = $result[2];
            $data[] = $result[3];
            $data[] = $args->getCurrencyFactor();
            $data[] = 19;
            $data[] = $args->getId();
            $data[] = session_id();

            $return = explode("?", $args->getReturn());

            foreach($return as &$entry) {
                $entry .= "'".array_shift($data)."'";
            }
            array_pop($return);
            $return = implode("", $return);

            return $args->setReturn($return);

        }

        if(preg_match("/Trauringe/",$result['articlename'])) {

                if(empty($config['Damenring-Größe']) && empty($config['Herrenringd-Größe'])) {
                    die(var_dump($_SESSION[session_id()]));
                 }

                $article = Shopware()->Db()->fetchRow("SELECT * FROM s_articles_attributes WHERE articleID = ?",$result['articleID']);

                if($config["Steinbesatz"] === "Ohne Stein/e") {
                    $function = "calculateMaterial";
                } else {
                    $function = $this->identifyStone($article['attr6']);
                }

                $wRing = 0;
                $mRing = 0;

                if($config['Ringwahl'] == "Paarringe" || $config['Ringwahl'] != "Herrenring") {

                    $wWidth = (float)$config['Damenring-Breite'];
                    $wThickness = (float)$config['Damenring-Stärke'];
                    $wRing = $wWidth * $wThickness;

                }

                if($config['Ringwahl'] == "Paarringe" || $config['Ringwahl'] != "Damenring") {

                    $mWidth = (float)$config['Herrenring-Breite'];
                    $mThickness = (float)$config['Herrenring-Stärke'];
                    $mRing = $mWidth * $mThickness;

                    if($config['Ringwahl'] === "Herrenring") {
                        $function = "calculateMaterial";
                    }

                }

                $area = $wRing + $mRing;
                $result = $this->$function($area,$article['attr13'],$article['attr7'],$config['Profil'],$article['attr6'],$this->getAmountOfStones($article['attr24']));

                $data = [];

                if(is_array($result)) {

                    $data[] = $args->getQuantity();
                    $data[] = $result[2];
                    $data[] = $result[3];
                    $data[] = $args->getCurrencyFactor();
                    $data[] = 19;
                    $data[] = $args->getId();
                    $data[] = session_id();

                } else {

                    $result = ceil($result / 5) * 5;

                    $data[] = $args->getQuantity();
                    $data[] = $result;
                    $data[] = $result / 1.19;
                    $data[] = $args->getCurrencyFactor();
                    $data[] = 19;
                    $data[] = $args->getId();
                    $data[] = session_id();

                }

        } else {

            $this->clarity = strtolower(str_replace("/","-",$config['Reinheit']));

            $article = Shopware()->Db()->fetchRow("SELECT a.id, a.name, b.attr5 as profile, b.attr6 as stone, b.attr7 as alloy,
                attr8 as width, weight, attr11 as quantity, attr13 as material, attr14, price,pseudoprice FROM s_articles a LEFT JOIN s_articles_attributes b ON a.id = b.articleID
                LEFT JOIN s_articles_details d ON a.id=d.articleID LEFT JOIN s_articles_prices e ON d.articleID = e.articleID WHERE a.id = ?",$result['articleID']);

            $result = $this->calculateVerlobungsring($article['weight'],$article['material'],$article['alloy'],$article['stone'],$article['quantity'],$article['attr14']);

            if(is_array($result)) {
                if($article['pseudoprice'] > 0) {
                    $percent = $result[4] * (100 - ($article['price'] * 100 / $article['pseudoprice']) / 100);
                } else {
                    $percent = 0;
                }

                $data[] = $args->getQuantity();
                $data[] = $_SESSION[$articleID.'-latestPrice'];
                $data[] = $_SESSION[$articleID.'-latestPrice']  / 1.19;
                $data[] = $args->getCurrencyFactor();
                $data[] = 19;
                $data[] = $args->getId();
                $data[] = session_id();

            }

        }

        $return = explode("?", $args->getReturn());

        foreach($return as &$entry) {
            $entry .= "'".array_shift($data)."'";
        }
        array_pop($return);
        $return = implode("", $return);

        $args->setReturn($return);

    }

    /**
     * @param ActionEventArgs $args
     */
    public function onPostDispatchCheckout(ActionEventArgs $args) {

        /** @var \Shopware_Controllers_Frontend_Checkout $controller */
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();


        if(strtolower($request->getControllerName()) === 'checkout' && strtolower($request->getActionName()) !== 'finish') {
            return;
        }

        $handle = fopen(__DIR__ . "/checkout.log","a");
        fwrite($handle, date("[".("d.m.Y H:i:s")."]" . "init\n"));

        $basket = $view->getAssign("sBasket")['content'];
        $userData = $view->getAssign("sUserData");
        $billing = $userData['billingaddress'];
        $shipping = $userData['shippingaddress'];
        $additional = $userData['additional'];
        $payment = $view->getAssign("sPayment");
        $ordernumber = $view->getAssign("sOrderNumber");
        $orderID = Shopware()->Db()->fetchOne("SELECT id FROM s_order WHERE ordernumber = ? ORDER BY id DESC",$ordernumber);

        $afterbuyID = Shopware()->Db()->fetchOne("SELECT attribute2 FROM s_order_attributes WHERE orderID = ?",$orderID);

        if(!empty($afterbuyID)) {
            return;
        }

        fwrite($handle, date("[".("d.m.Y H:i:s")."]" . "neue Bestellung\n"));

        $transID = Shopware()->Db()->fetchOne("SELECT transactionID FROM s_order WHERE id = ?",$orderID);
        $intComment = Shopware()->Db()->fetchOne("SELECT internalcomment FROM s_order WHERE id = ?",$orderID);

        // $info type of stdClass
        if(!empty($intComment)) {
            $info = json_decode($intComment);

            $checkInfo = Shopware()->Db()->fetchOne("SELECT id FROM s_payment_paypal_plus_payment_instruction WHERE ordernumber = ?",$ordernumber);

            if(empty($checkInfo)) {
                Shopware()->Db()->query("INSERT INTO `s_payment_paypal_plus_payment_instruction` 
                (`ordernumber`, `reference_number`, `instruction_type`, `bank_name`, `account_holder_name`, 
                `international_bank_account_number`, `bank_identifier_code`, `amount_value`, `amount_currency`, 
                `payment_due_date`, `links`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$ordernumber,$info->reference,"PAY_UPON_INVOICE",$info->bankName,
                $info->accountHolder,$info->iban,$info->bic,$info->amount,"EUR",$info->dueDate,""]);
            }

        }

        $posQuantity = 0;
        foreach($basket as $entry) {
            if($entry['modus'] == 0) {
                $posQuantity++;
            }
        }

        $data = "";

        $billing['salutation'] === "mr" ? $data .= "&Kanrede=" . "Herr" : $data .= "&Kanrede=" . "Frau";

        if(!empty($billing['company'])) {
            $data .= "&KFirma=" .urlencode($billing['company']);
        }

        $data .= "&KVorname=" . urlencode($billing['firstname']);
        $data .= "&KNachname=" . urlencode($billing['lastname']);
        $data .= "&KStrasse=" . urlencode($billing['street']);
        $data .= "&KPLZ=" . $billing['zipcode'];
        $data .= "&KOrt=" . urlencode($billing['city']);
        $data .= "&Kemail=" . urlencode($additional['user']['email']);
        $additional['country']['countryiso'] === "DE" ? $data .= "&KLand=" . "D" : $data .= "&KLand=" . $additional['country']['countryiso'];
        $data .= "&KTelefon=" . $billing['phone'];

        if($billing['company'] != $shipping['company'] || $billing['firstname'] != $shipping['firstname'] ||
            $billing['lastname'] != $shipping['lastname'] || $billing['street'] != $shipping['street'] ||
            $billing['zipcode'] != $shipping['zipcode'] || $billing['city'] != $shipping['city'] || $billing['phone'] != $shipping['phone'])
        {

            $data .= "&Lieferanschrift=1";

            if(!empty($billing['company'])) {
                $data .= "&KLFirma=" .urlencode($shipping['company']);
            }

            $data .= "&KLVorname=" . urlencode($shipping['firstname']);
            $data .= "&KLNachname=" . urlencode($shipping['lastname']);
            $data .= "&KLStrasse=" . urlencode($shipping['street']);
            $data .= "&KLPLZ=" . $shipping['zipcode'];
            $data .= "&KLOrt=" . urlencode($shipping['city']);
            $data .= "&KLemail=" . urlencode($shipping['user']['email']);
            $additional['country']['countryiso'] === "DE" ? $data .= "&KLLand=" . "D" : $data .= "&KLLand=" . $additional['country']['countryiso'];
            //$data .= "&KLLand=" . $shipping['country']['countryiso'] === "DE" ? "D" : $additional['country']['countryiso'];
            $data .= "&KLTelefon=" . $shipping['phone'];

        }

        fwrite($handle, date("[".("d.m.Y H:i:s")."]" . "daten erfasst\n"));

        $data .= "&Kommentar=" . urlencode($view->getAssign("sComment",""));
        $data .= "&NoFeedback=2&Kundenerkennung=1&Artikelerkennung=1&Bestandart=auktion&NoVersandCalc=1&BuyDate=".date("d.m.Y H:i:s");
        $data .= "&NoeBayNameAktu=0&EKundenNr=".($billing['userID'] + 290000);

        switch($payment['id']) {
            case "12":
                $data .= "&Zahlart=".urlencode($payment['description']);
                $data .= "&SetPay=1";
                break;
            case "11":
                $data .= "&Zahlart=".urlencode($payment['description']);
                $data .= "&SetPay=1";
                break;
            case "9":
                $id = Shopware()->Db()->fetchOne("SELECT id FROM `s_payment_paypal_plus_payment_instruction` WHERE ordernumber = ?",$ordernumber);
                empty($id) === true ? $data .= "&Zahlart=Paypal" : $data .= "&Zahlart=Paypal-Rechnung";
                break;
            case "5":
                $id = Shopware()->Db()->fetchOne("SELECT id FROM `s_payment_paypal_plus_payment_instruction` WHERE ordernumber = ?",$ordernumber);
                empty($id) === false ? $data .= "&Zahlart=Paypal-Rechnung" : $data .= "&Zahlart=" . urlencode("Vorkasse/Überweisung");
                break;
            case "7":
                $data .= "&Zahlart=Klarna-Ratenkauf&ZFunktionsID=99";
                $data .= "&SetPay=1";
                break;
            case "8":
                $data .= "&Zahlart=Klarna-Rechnung&ZFunktionsID=99";
                $data .= "&SetPay=1";
                break;
            case "10":
                $data .= "&Zahlart=PayPal-Ratenkauf&ZFunktionsID=99";
                break;
            default:
                $id = 0;
                break;
        }

        if(!empty($transID)) {
            $data .= "&PaymentTransactionId=".urlencode($transID);
            $data .= "&SetPay=1";
        }
        fwrite($handle, date("[".("d.m.Y H:i:s")."]" . "Zahlungsart:".$payment['id']."\n"));
        $i = 1;

        foreach($basket as $entry) {

            if($entry['modus'] == 0) {

                $articleUrl = Shopware()->Db()->fetchOne("SELECT path FROM s_core_rewrite_urls WHERE org_path = ? AND main = 1", "sViewport=detail&sArticle=" . $entry['articleID']);

                if (empty($articleUrl)) {
                    $articleUrl = Shopware()->Router()->assemble(['controller' => 'detail', 'sArticle' => $entry['articleID']]);
                }

                $data .= "&Artikelnr_".$i ."=" . $entry['ordernumber'];
                $data .= "&Artikelname_".$i ."=" . urlencode($entry['articlename']);
                $data .= "&ArtikelEpreis_".$i ."=" . $entry['priceNumeric'];
                $data .= "&ArtikelMwSt_".$i ."=".$entry['tax_rate'];
                $data .= "&ArtikelMenge_".$i ."=1";
                $data .= "&ArtikelLink_".$i ."=". urlencode("https://ewigetrauringe.de/".$articleUrl . "#" . $entry['customProductHash']);
                $data .= "&ArtikelStammID_".$i ."=" . $entry['ordernumber'];
                $data .= "&Attribute_".$i ."=";

                $ringChoice = "Paarringe";

                foreach($entry['custom_product_adds'] as $option) {

                    if($option['name'] === "Legierung") {
                        continue;
                    }

                    if($option['name'] === "Profil") {
                        if($option["values"][0]['name'] !== "Standard-Profil") {
                            $data .= "Profil:" . substr($option["values"][0]['name'],-1) . "|";
                        } else {
                            $data .= "Profil:0|";
                        }

                        continue;
                    }

                    if($option['name'] === "Ringwahl") {
                        $ringChoice = $option["values"][0]['name'];
                        continue;
                    }

                    if(preg_match("/Herren/",$option['name']) && $ringChoice === "Damenring") {
                        continue;
                    }

                    if((preg_match("/Damen/",$option['name']) || preg_match("/Steinbesatz/",$option['name'])) && $ringChoice === "Herrenring") {
                        continue;
                    }

                    if(preg_match("/Breite/",$option['name']) || preg_match("/Stärke/",$option['name'])
                        || preg_match("/Gravur/",$option['name']) || preg_match("/Notiz/",$option['name'])) {

                        if(preg_match("/Gravur/",$option['name'])) {

                            if(empty($option["selectedValue"][0])) {
                                $data .= $option['name'] . ":-|";
                            } else {
                                $data .= $option['name'] . ":" . urlencode(str_replace(["{","[","]","}"],["♡","❧","⚭","∞"],$option["selectedValue"][0])) . "|";
                            }

                        } else {
                            $data .= $option['name'] . ":" . urlencode($option["selectedValue"][0]) . "|";
                        }

                    } else {
                        if($option['name'] == "Steinbesatz" && !preg_match("/Verlobungsring/",$entry['articlename'])) {
                            $option['name'] = "Steinbesatz Damenring";
                        }
                        $data .= $option['name'] . ":" . urlencode($option['values'][0]['name']) . "|";
                    }

                }

                substr($data,0,-1);
                $i++;

            }

        }

        $parts = explode("&",$data);
        $newData = [];

        foreach($parts as $key => $part) {
            if(!empty($part)) {
                $newData[$part] = $part;
            }
        }

        $data = implode("&", $newData);

        $login = "Action=new&Partnerid=" . $this->config['partnerID'] . "&PartnerPass=" . $this->config['partner_password'] .
            "&UserID=" . $this->config['ab_loginID'] . "&VID=Shopware_".$ordernumber."&CheckVID=1&Kbenutzername=Shopware_".$ordernumber."&PosAnz=".$posQuantity;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.afterbuy.de/afterbuy/ShopInterfaceUTF8.aspx");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $login."&".$data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, 60);
        curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 1);

        $Xml = simplexml_load_string(curl_exec($ch));

        curl_close($ch);

        $transfered = 0;
        $resultText = "";
        $AfterbuyID = "";

        if ((string)$Xml->success == "1") {

            $AfterbuyID = (string)$Xml->data->AID;
            $resultText .= (string)$Xml->data->UID."\n";
            $resultText .= (string)$Xml->data->KundenNr."\n";
            $resultText .= (string)$Xml->data->EKundeNr."\n";
            $transfered = 1;

        }
        else {

            foreach($Xml->errorlist->error as $name => $entry) {
                $resultText .= (string)$name . ":" . (string)$entry."\n";
            }

            mail('seo@ewigetrauringe.de', 'Bestellung konnte nicht übermittelt werden', utf8_encode('Die Bestellung mit der Nr: '.$ordernumber.' konnte nicht übertragen werden\n\n log:').$resultText);
            mail('mm@asf-trauringe.de', 'Bestellung konnte nicht übermittelt werden', utf8_encode('Die Bestellung mit der Nr: '.$ordernumber.' konnte nicht übertragen werden\n\n log:').$resultText);
            mail('f.jacob@asf-trauringe.de', 'Bestellung konnte nicht übermittelt werden', utf8_encode('Die Bestellung mit der Nr: '.$ordernumber.' konnte nicht übertragen werden\n\n log:').$resultText);

        }

        $resultText .= "\n\n Bestellungslink: https://api.afterbuy.de/afterbuy/ShopInterfaceUTF8.aspx?" . "Action=new&Partnerid=" . $this->config['partnerID'] . "&PartnerPass=" . $this->config['partner_password'] .
            "&UserID=" . $this->config['ab_loginID'] . "&VID=Shopware_".$ordernumber."&CheckVID=1&Kbenutzername=Shopware_".$ordernumber."&PosAnz=".$posQuantity."&".$data;

        fclose($handle);

        Shopware()->Db()->query("UPDATE s_order_attributes SET attribute1 = ? , attribute2 = ? , attribute3 = ? WHERE orderID = ?",
            [$transfered,$AfterbuyID,$resultText,Shopware()->Db()->fetchOne("SELECT id FROM s_order WHERE ordernumber = ?",$ordernumber)]);


    }

}