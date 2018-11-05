{block name="backend/base/header/css"}
    {$smarty.block.parent}
    <style type="text/css">
        .asf_afterbuy {
            background: url({link file="custom/plugins/AsfAfterbuy/Resources/views/backend/_resources/img/asf_afterbuy.png"}) no-repeat !important;
        }
        .sprite-afterbuy {
            background-position: -28px 0 !important;
        }
        .sprite-ring {
            background-position: 0 0 !important;
        }
        .sprite-shopware-to-afterbuy {
            background-position: -26px -30px !important;
        }
        .sprite-afterbuy-to-shopware {
            background-position: 0 -30px !important;
        }

    </style>
{/block}
