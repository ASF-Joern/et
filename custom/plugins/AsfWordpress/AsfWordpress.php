<?php

namespace AsfWordpress;

use Shopware\Components\Plugin;

class AsfWordpress extends Plugin {

    /**
     * @return array
     */
    public static function getSubscribedEvents() {

        return [
            'Enlight_Controller_Dispatcher_ControllerPath_Widgets_AsfWordpress' => 'onGetAsfWordpress',
        ];

    }

    /**
     * @return string
     */
    public function onGetAsfWordpress() {
        return __DIR__ . '/Controllers/Widgets/AsfWordpress.php';
    }

}