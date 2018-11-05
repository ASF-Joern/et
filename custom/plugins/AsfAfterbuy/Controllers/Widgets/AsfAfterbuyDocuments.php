<?php


class Shopware_Controllers_Widgets_AsfAfterbuyDocuments extends Enlight_Controller_Action
{

    /**
     * @var array
     */
    private $config;

    public function init() {
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('AsfAfterbuy');
    }

    /**
     * Is always called before the requested controller action is called
     */
    public function preDispatch() {
        //Shopware()->Front()->Plugins()->ViewRenderer()->setNoRender();
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    /**
     * Detect requested document, send or display it
     *
     * @return string
     */
    public function indexAction() {

        $params = $this->Request()->getParams();

        if(!empty($params['tpl']) && empty($params['preview'])) {

            $this->View()->assign("tpl", $params['tpl']);
            $this->View()->assign("article", "Trauringe Mülheim 333er Rotgold - 9875");
            $this->View()->assign("profile", "4");
            $this->View()->assign("wSize", "45mm (Ø 14,3mm)");
            $this->View()->assign("wWidth", "5,5mm");
            $this->View()->assign("wThickness", "1,6mm");
            $this->View()->assign("wEngraving", "Testgravur Dame");
            $this->View()->assign("stone", "0,03ct. Tw/Si (1 x 0,03ct. Brillant)");
            $this->View()->assign("mSize", "61mm (Ø 19,4mm)");
            $this->View()->assign("mWidth", "6,5mm");
            $this->View()->assign("mThickness", "1,6mm");
            $this->View()->assign("mEngraving", "Testgravur Herr");
            $this->View()->assign("articleNumber", "130179875");
            $this->View()->assign("buyDate", "12.07.2018 15:35:42");
            $this->View()->assign("salutation", "Herr");
            $this->View()->assign("firstname", "Marcel");
            $this->View()->assign("lastname", "Meier");
            $this->View()->assign("street", "Brunnenweg 2");
            $this->View()->assign("tel", "235974895734");
            $this->View()->assign("plz", "35390");
            $this->View()->assign("city", "Gießen");
            $this->View()->assign("country", "Deutschland");
            $this->View()->assign("printdate", date("d.m.Y H:i:s"));
            $this->View()->assign("billNr", "17563");
            $this->View()->assign("customernumber", "326651582");
            $this->View()->assign("model", "Mülheim");
            $this->View()->assign("company", "");
            $this->View()->assign("alloy", "333er");
            $this->View()->assign("color", "Rotgold");
            $this->View()->assign("payKind", "Vorkasse");
            $this->View()->assign("payed", "");
            $this->View()->assign("price", "550,00");
            $this->View()->assign("barcodeLeft", "http://farm01.afterbuy.de/afterbuy/barcode.aspx?BType=4&Height=60&Width=190&Text=1&TextSize=10&Font=Arial&Scaling=1&Data=17563&PZ=0");
            $this->View()->assign("barcodeRight", "http://farm01.afterbuy.de/afterbuy/barcode.aspx?BType=4&Height=60&Width=190&Text=1&TextSize=10&Font=Arial&Scaling=1&Data=ET17563&PZ=0");
            $this->View()->assign("note", "Schriftart Script 412 1L     zwei verschlungene Herzen zwischen Name und Datum");

            $path = Shopware()->Db()->fetchOne("SELECT path FROM s_media a
                LEFT JOIN s_articles_img c
                ON a.id = c.media_id
                LEFT JOIN s_articles_details b 
                ON c.articleID = b.articleID
                WHERE b.ordernumber = ?","130179875");

            $mediaService = Shopware()->Container()->get('shopware_media.media_service');

            $path = substr(str_replace("image", "image/thumbnails", $path), 0, -4) . '_800x800.jpg';
            $this->View()->assign("picture", $mediaService->getUrl($path));

        } else {
            $this->preview();
        }

    }

    private function preview() {

        $params = $this->Request()->getParams();

        $this->View()->assign("tpl", $params['tpl']);
        $this->View()->assign("profile", "#profileNr#");
        $this->View()->assign("wSize", "#wSize#");
        $this->View()->assign("wWidth", "#wWidth#");
        $this->View()->assign("wThickness", "#wThickness#");
        $this->View()->assign("wEngraving", "#wEngraving#");
        $this->View()->assign("stone", "#stone#");
        $this->View()->assign("mSize", "#mSize#");
        $this->View()->assign("mWidth", "#mWidth");
        $this->View()->assign("mThickness", "#mThickness#");
        $this->View()->assign("mEngraving", "#mEngraving#");
        $this->View()->assign("articleNumber", "<-Artikelnummer->");
        $this->View()->assign("buyDate", "<-EndeDerAuktionShort->");
        $this->View()->assign("company", "<-KLFIRMA->");
        $this->View()->assign("firstname", "<-KLVorname->");
        $this->View()->assign("lastname", "<-KLNachname->");
        $this->View()->assign("street", "<-KLStrasse-><-KLAnschrift2->");
        $this->View()->assign("tel", "<-KTELEFON->");
        $this->View()->assign("plz", "<-KLPLZ->");
        $this->View()->assign("city", "<-KLOrt->");
        $this->View()->assign("country", "<-KLLandPost->");
        $this->View()->assign("printdate", "<-Datum->");
        $this->View()->assign("billNr", "<-ReNr->");
        $this->View()->assign("customernumber", "<-KNummer->");
        $this->View()->assign("model", "<-RELOOP START-><-if <-Artikelnummer-> <> 99999997 -><-if <-Artikelnummer-> <> 99999996 -><-if <-Artikelnummer-> <> 99999995 -><-freifeld8-><- end if -><- end if -><- end if -><-RELOOP END->");
        $this->View()->assign("alloy", "<-Freifeld1->");
        $this->View()->assign("color", "<-Freifeld2->");
        $this->View()->assign("payKind", "<-Zahlart->");
        $this->View()->assign("payed", "<-if <-Zahlart-> <> Nachnahme ->  <li style=\"border-bottom: 1px solid gray; font-size:.8em; word-break: break-all;\"><span style=\"background:none;\"> Bezahlt am:</span><-Bezahlt-></li> <- end if ->");
        $this->View()->assign("feedback", "<-Feedback->");
        $this->View()->assign("price", "<-Summe->");
        $this->View()->assign("barcodeLeft", "http://farm01.afterbuy.de/afterbuy/barcode.aspx?BType=4&Height=40&Width=150&Text=1&TextSize=10&Font=Arial&Scaling=1&Data=<-ReNr->&PZ=0");
        $this->View()->assign("barcodeRight", "http://farm01.afterbuy.de/afterbuy/barcode.aspx?BType=4&Height=40&Width=150&Text=1&TextSize=10&Font=Arial&Scaling=1&Data=ET<-ReNr->&PZ=0");
        $this->View()->assign("note", "#note#");

    }

}
