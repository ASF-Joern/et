<?php

namespace AsfAfterbuy;

use Shopware\Components\Plugin;

class AsfAfterbuy extends Plugin {

    /**
     * @return array
     */
    public static function getSubscribedEvents() {

        return [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_AsfAfterbuy' => 'onGetBackendController',
            'Enlight_Controller_Dispatcher_ControllerPath_Widgets_AsfWordpress' => 'onGetAsfWordpress',
            'Enlight_Controller_Dispatcher_ControllerPath_Widgets_AsfAfterbuyDownloadManager' => 'onGetAfterBuyDownloader',
        ];

    }

    /**
     * @return string
     */
    public function onGetBackendController() {
        return __DIR__ . '/Controllers/Backend/AsfAfterbuy.php';
    }

    /**
     * @return string
     */
    public function onGetAsfWordpress() {
        return __DIR__ . '/Controllers/Widgets/AsfWordpress.php';
    }

    /**
     * @return string
     */
    public function onGetAfterBuyDownloader() {
        return __DIR__ . '/Controllers/Widgets/AsfAfterbuyDownloadManager.php';
    }

}