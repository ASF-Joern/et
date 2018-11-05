<?php

class Shopware_Controllers_Widgets_AsfProfiles extends Enlight_Controller_Action
{

    /**
     * @var array
     */
    private $config;

    public function init() {
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('AsfRingManager');
    }

    /**
     * Is always called before the requested controller action is called
     */
    public function preDispatch(){
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    /**
     * Loads all profiles from the given articleID
     *
     * @return bool|void
     */
    public function indexAction() {

        $profileNr = $this->Request()->getParam("profile", null);
        $articleID = $this->Request()->getParam("articleID", null);

        // We can't process correctly if one of this parameter is empty
        if(empty($profileNr) || empty($articleID)) {

            return false;
        }

        $profiles = Shopware()->Db()->fetchOne("SELECT attr4 FROM s_articles_attributes WHERE articleID = ?",$articleID);

        $this->View()->assign("articleID", $articleID);
        $this->View()->assign("profileNr", $profileNr);
        $this->View()->assign("profiles", explode(";", $profiles));



    }
}
