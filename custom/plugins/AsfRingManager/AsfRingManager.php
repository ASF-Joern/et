<?php

namespace AsfRingManager;

use Shopware\Components\Plugin;

class AsfRingManager extends Plugin {

    /**
     * @return array
     */
    public static function getSubscribedEvents() {

        return [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_AsfRingManager' => 'onGetAsfRingManager',
            'Enlight_Controller_Dispatcher_ControllerPath_Widgets_AsfRingManager' => 'onGetAsfRingManagerWidget',
            'Enlight_Controller_Dispatcher_ControllerPath_Widgets_AsfProfiles' => 'onGetAsfProfilesWidget',
        ];

    }

    /**
     * @return string
     */
    public function onGetAsfRingManager() {
        return __DIR__ . '/Controllers/Backend/AsfRingManager.php';
    }

    /**
     * @return string
     */
    public function onGetAsfRingManagerWidget() {
        return __DIR__ . '/Controllers/Widgets/AsfRingManager.php';
    }

    /**
     * @return string
     */
    public function onGetAsfProfilesWidget() {
        return __DIR__ . '/Controllers/Widgets/AsfProfiles.php';
    }

}