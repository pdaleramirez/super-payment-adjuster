<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster;

use craft\commerce\services\OrderAdjustments;
use craft\events\RegisterComponentTypesEvent;
use pdaleramirez\superpaymentadjuster\adjusters\PaymentMethodAdjuster;
use pdaleramirez\superpaymentadjuster\plugin\Routes;
use pdaleramirez\superpaymentadjuster\plugin\Services;
use Craft;
use craft\base\Plugin;
use pdaleramirez\superpaymentadjuster\services\App;
use yii\base\Event;

/**
 * Class SuperPaymentAdjuster
 *
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 *
 */
class SuperPaymentAdjuster extends Plugin
{
    use Services;
    use Routes;

    /**
     * @var App
     */
    public static $app;

    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @var bool
     */
    public bool $hasCpSection = true;

    public function init()
    {
        parent::init();

        $this->_setPluginComponents();
        $this->_registerCpRoutes();

        self::$app = $this;

        Event::on(
            OrderAdjustments::class,
            OrderAdjustments::EVENT_REGISTER_ORDER_ADJUSTERS,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = PaymentMethodAdjuster::class;
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function getCpNavItem(): array
    {
        $ret = parent::getCpNavItem();

        $ret['label'] = Craft::t('super-payment-adjuster', 'Super Payment Adjuster');

        $ret['subnav']['payment-adjusters'] = [
            'label' => Craft::t('super-payment-adjuster', 'Payment Adjusters'),
            'url' => 'super-payment-adjuster/payment-adjusters'
        ];

        return $ret;
    }
}
