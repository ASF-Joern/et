<?php


class Shopware_Controllers_Widgets_AsfWordpress extends Enlight_Controller_Action
{

    /**
     * Is always called before the requested controller action is called
     */
    public function preDispatch() {
        Shopware()->Front()->Plugins()->ViewRenderer()->setNoRender();
        //$this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    /**
     *
     */
    public function indexAction() {
        $WP = new \AsfAfterbuy\Components\Wordpress();

        $WP->importArticles();
    }

}
