<?php

namespace AsfRingManager\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs as ActionEventArgs;

class Forms implements SubscriberInterface
{

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onPostDispatchForms',
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
     * @param ActionEventArgs $args
     */
    public function onPostDispatchForms(ActionEventArgs $args) {

        /** @var \Shopware_Controllers_Frontend_Checkout $controller */
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();

        if(strtolower($request->getControllerName()) === 'forms' && strtolower($request->getActionName()) !== 'index') {
            return;
        }

        if(empty($_POST)) {
            return;
        }

        $id = $view->getAssign("id","0");

        if($id !== "24") {
            return;
        }


        $dataSet = Shopware()->Db()->fetchAll("SELECT * FROM `asf_afterbuy_multisizer` WHERE email = ?",$_POST['email']);

        if(!empty($dataSet)) {

            $d1 = new \DateTime("now");
            $d2 = new \DateTime($dataSet['datum']);

            $interval = date_diff($d2,$d1);
            $days = (int)$interval->format('%a');

            if($days <= 1) {
                return;
            }

            return;

        }

        // DIRTY
        $ordernumber = Shopware()->Db()->fetchOne("SELECT `number` FROM s_order_number WHERE id = 926");
        Shopware()->Db()->query("UPDATE s_order_number SET number = ? WHERE id = 926", ($ordernumber + 1));

        $data = "Action=new&Partnerid=" . $this->config['partnerID'] . "&PartnerPass=" . $this->config['partner_password'] .
            "&UserID=" . $this->config['ab_loginID'] . "&Kbenutzername=ShopwareRingGroesse_" . $ordernumber . "&PosAnz=1";

        $data .= "&Kanrede=" . $_POST['salutation'];
        $data .= "&KVorname=" . urlencode($_POST['firstName']);
        $data .= "&KNachname=" . urlencode($_POST['lastName']);
        $data .= "&KStrasse=" . urlencode($_POST['street']);
        $data .= "&KPLZ=" . $_POST['zipCode'];
        $data .= "&KOrt=" . urlencode($_POST['city']);
        $data .= "&Kemail=" . urlencode($_POST['email']);
        $data .= "&KLand=" . "D";
        $data .= "&KTelefon=" . $_POST['tel'];

        $data .= "CheckVID=1&";
        $data .= "VID=ShopwareRingGroesse_" . $ordernumber."&";
        $data .= "Bestandart=auktion&";
        $data .= "Kundenerkennung=1&";
        $data .= "NoeBayNameAktu=1&";

        $data .= "BuyDate=" . date('d.m.Y H:i:s', time()) . "&";
        $data .= "NoVersandCalc=1&";
        $data .= "Artikelerkennung=1&";
        $data .= "Bestandart=shop&";
        $data .= "Zahlart=Kostenlos&";
        $data .= "SetPay=1&";
        $data .= "Versandart=Versand&";
        $data .= "Versandkosten=0&";

        $data .= "Artikelname_1=" . urlencode('Multisizer Ringmass zur Bestimmung ihrer Ringgröße¸e') . "&";
        $data .= "ArtikelStammID_1=42340881&";
        $data .= "Artikelnr_1=42340881&";
        $data .= "ArtikelEPreis_1=0&";
        $data .= "ArtikelMwSt_1=19&";
        $data .= "ArtikelMenge_1=1&";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.afterbuy.de/afterbuy/ShopInterfaceUTF8.aspx");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, 60);
        curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 1);

        $Xml = simplexml_load_string(curl_exec($ch));
        curl_close($ch);

        $resultText = "";

        if ((string)$Xml->success == "1") {

            $AfterbuyID = (string)$Xml->data->AID;
            $resultText .= (string)$Xml->data->UID."\n";
            $resultText .= (string)$Xml->data->KundenNr."\n";
            $resultText .= (string)$Xml->data->EKundeNr."\n";

        }
        else {
            foreach($Xml->errorlist->error as $name => $entry) {
                $resultText .= (string)$name . ":" . (string)$entry."\n";
            }
        }

        $resultText .= "\n\n Bestellungslink: https://api.afterbuy.de/afterbuy/ShopInterfaceUTF8.aspx?" . $data;

        Shopware()->Db()->query("INSERT INTO `asf_afterbuy_multisizer` (`salutation`, `firstname`, `lastname`,
            `street`, `zipcode`, `city`, `email`, `country`, `phone`, `datum`, `log`) VALUES (?,?,?,?,?,?,?,?,?,?,?)",
        [$_POST['salutation'],$_POST['firstName'],$_POST['lastName'],$_POST['street'],$_POST['zipCode'],$_POST['city'],$_POST['email'],"Deutschland",$_POST['tel'],date("Y-m-d H:i:s"),$resultText]);

    }

}