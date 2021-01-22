<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\utilities;

use pdaleramirez\superpaymentadjuster\SuperPaymentAdjuster;
use pdaleramirez\superpaymentadjuster\assetbundles\superpaymentadjusterutilityutility\SuperPaymentAdjusterUtilityUtilityAsset;

use Craft;
use craft\base\Utility;

/**
 * Super Payment Adjuster Utility
 *
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class SuperPaymentAdjusterUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('super-payment-adjuster', 'SuperPaymentAdjusterUtility');
    }

    /**
     * @inheritdoc
     */
    public static function id(): string
    {
        return 'superpaymentadjuster-super-payment-adjuster-utility';
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@pdaleramirez/superpaymentadjuster/assetbundles/superpaymentadjusterutilityutility/dist/img/SuperPaymentAdjusterUtility-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(SuperPaymentAdjusterUtilityUtilityAsset::class);

        $someVar = 'Have a nice day!';
        return Craft::$app->getView()->renderTemplate(
            'super-payment-adjuster/_components/utilities/SuperPaymentAdjusterUtility_content',
            [
                'someVar' => $someVar
            ]
        );
    }
}
