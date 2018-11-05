<?php

use Shopware\Components\Model\ModelManager;

class Shopware_Controllers_Frontend_SitemapLandingpages extends Enlight_Controller_Action
{

    public function preDispatch() {

    }

    /**
     * Index action of the payment. The only thing to do here is to forward to the gateway action.
     */
    public function indexAction() {

        $this->Response()->setHeader('Content-Type', 'text/xml; charset=utf-8');
        set_time_limit(0);

        $result = Shopware()->Db()->fetchAll("SELECT * FROM `s_cms_static` WHERE active = 1");

        echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach($result as $key => $val) {

            $url = "https://ewigetrauringe.de/" . strtolower(Shopware()->Db()->fetchOne("SELECT path FROM s_core_rewrite_urls WHERE main = 1 AND org_path LIKE 'sViewport=custom&sCustom=".$val['id']."'"));

            if(empty($url)) {
                continue;
            }

            echo "<url><loc><![CDATA[".$url;

            echo "]]></loc><lastmod><![CDATA[";

            echo explode(" ",$val['changed'])[0]."]]></lastmod><changefreq><![CDATA[weekly]]></changefreq><priority><![CDATA[0.5]]></priority></url>";

        }

        echo "</urlset>";

    }

}
