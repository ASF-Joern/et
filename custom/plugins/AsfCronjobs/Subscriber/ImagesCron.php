<?php

namespace AsfCronjobs\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\DependencyInjection\Container;

/**
 * Class ImagesCron
 * @package AsfCronjobs\Subscriber
 */
class ImagesCron implements SubscriberInterface
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_AsfCronjobsImagesCron' => 'runImagesCron'
        ];
    }

    /**
     * QueryManagerCron constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function runImagesCron(\Shopware_Components_Cron_CronJob $job)
    {
        die("ImagesCron");

        return $data;
    }
}