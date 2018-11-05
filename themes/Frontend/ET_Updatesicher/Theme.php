<?php

namespace Shopware\Themes\ET_Updatesicher;

use Shopware\Components\Form as Form;

class Theme extends \Shopware\Components\Theme
{
    protected $extend = 'Responsive';

    protected $name = <<<'SHOPWARE_EOD'
Stellt das Design von ET dar in einer update sicheren Version
SHOPWARE_EOD;

    protected $injectBeforePlugins =  false;

    protected $description = <<<'SHOPWARE_EOD'

SHOPWARE_EOD;

    protected $author = <<<'SHOPWARE_EOD'
Marcel Meier
SHOPWARE_EOD;

    protected $license = <<<'SHOPWARE_EOD'

SHOPWARE_EOD;

    /** @var array Defines the files which should be compiled by the javascript compressor */
    protected $css = array(
        'src/css/et.css',
        //'src/css/fontawesome-all.min.css',
		'src/css/custom_products.css',
    );

    protected $javascript = [
        //'src/js/jquery.asf_add_and_sub.js',
        //'src/js/jquery.asf_hidden_radio.js',
        //'src/js/jquery.asf_switch_color.js',
        //'src/js/jquery.asf_switch_alloy_or_stone.js',
        //'src/js/jquery.asf_set_stones.js',
        //'src/js/jquery.asf_add_symbols.js',
        'src/js/jquery.asf_ring_manager.js',
        //'src/js/jquery.asf_price_manager.js',
        'src/js/jquery.asf_overrides.js',
        'src/js/jquery.asf_state_manager.js',
        //'src/js/jquery.asf_change_fonts.js',
    ];

    public function createConfig(Form\Container\TabContainer $container)
    {
    }
}