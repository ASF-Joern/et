<?php

namespace AsfCronjobs;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;

class AsfCronjobs extends Plugin
{

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('asf_cronjobs.plugin_dir', $this->getPath());

        parent::build($container);
    }

    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $sql = file_get_contents($this->getPath() . '/Resources/sql/install.sql');

        $this->container->get('shopware.db')->query($sql, array($context->getPlugin()->getId(),$context->getPlugin()->getId()));
    }
}
?>