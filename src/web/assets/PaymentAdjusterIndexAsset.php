<?php
namespace pdaleramirez\superpaymentadjuster\web\assets;

use craft\commerce\web\assets\commercecp\CommerceCpAsset;
use craft\web\AssetBundle;

class PaymentAdjusterIndexAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/dist';

        $this->depends = [
            CommerceCpAsset::class,
        ];

        $this->js = [
            'js/PaymentAdjusterIndex.js',
        ];

        parent::init();
    }
}
