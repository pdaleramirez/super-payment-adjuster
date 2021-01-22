<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\assetbundles\superpaymentadjuster;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class SuperPaymentAdjusterAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@pdaleramirez/superpaymentadjuster/assetbundles/superpaymentadjuster/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/SuperPaymentAdjuster.js',
        ];

        $this->css = [
            'css/SuperPaymentAdjuster.css',
        ];

        parent::init();
    }
}
