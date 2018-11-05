<?php

namespace AsfAfterbuy\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs as ActionEventArgs;
use Shopware\Components\DependencyInjection\Container as DIContainer;

class Backend implements SubscriberInterface
{
    /**
     * @var DIContainer
     */
    private $container;

    /**
     * @var
     */
    private $pluginRoot;

    /**
     * @param DIContainer $container
     * @param string      $pluginRoot
     */
    public function __construct(DIContainer $container, $pluginRoot) {
        $this->container = $container;
        $this->pluginRoot = $pluginRoot;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        return ['Enlight_Controller_Action_PostDispatchSecure_Backend_Index' => 'extendMenu'];
    }

    /**
     * Loads the menu icon
     *
     * @param ActionEventArgs $args
     */
    public function extendMenu(ActionEventArgs $args) {
        /** @var \Shopware_Controllers_Backend_Index $subject */
        $view = $args->getSubject()->View();

        $this->registerTemplateDir();

        $view->extendsTemplate('backend/asf_afterbuy/menu_item.tpl');
    }

    /**
     * registers the Views/ directory as template directory
     */
    private function registerTemplateDir() {
        /** @var \Enlight_Template_Manager $template */
        $template = $this->container->get('template');

        $template->addTemplateDir($this->pluginRoot . '/Resources/views/');
    }

}
