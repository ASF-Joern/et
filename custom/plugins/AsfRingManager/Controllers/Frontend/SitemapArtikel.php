<?php

use Shopware\Components\Model\ModelManager;

class Shopware_Controllers_Frontend_SitemapArtikel extends Enlight_Controller_Action
{

    public function preDispatch() {

    }

    /**
     * Index action of the payment. The only thing to do here is to forward to the gateway action.
     */
    public function indexAction() {

        $this->Response()->setHeader('Content-Type', 'text/xml; charset=utf-8');
        set_time_limit(0);

        $result = Shopware()->Db()->fetchAll("SELECT * FROM s_articles WHERE active = 1 LIMIT 10");

        /* create a dom document with encoding utf8 */
        $domtree = new DOMDocument('1.0', 'UTF-8');

        $xmlRoot = $domtree->createElement("urlset");
        $xmlRoot->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
        /* append it to the document created */
        $xmlRoot = $domtree->appendChild($xmlRoot);

        //$xml = new SimpleXMLElement('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

        foreach($result as $key => $val) {

            $url = "https://ewigetrauringe.de/" . strtolower(Shopware()->Db()->fetchOne("SELECT path FROM s_core_rewrite_urls WHERE main = 1 AND org_path LIKE 'sViewport=detail&sArticle=".$val['id']."'"));

            $currentTrack = $domtree->createElement("url");
            $currentTrack = $xmlRoot->appendChild($currentTrack);

            /* you should enclose the following two lines in a cicle */
            $currentTrack->appendChild($domtree->createElement('loc',$url));
            $currentTrack->appendChild($domtree->createElement('lastmod',explode(" ",$val['changetime'])[0]));
            $currentTrack->appendChild($domtree->createElement('changefreq','weekly'));
            $currentTrack->appendChild($domtree->createElement('changefreq','0.5'));

        }

        $handle = fopen(__DIR__ . "/../kategorien.xml", "w");
        fwrite($handle, $domtree->saveXML());
        fclose($handle);
        print($domtree->saveXML());
    }

}
