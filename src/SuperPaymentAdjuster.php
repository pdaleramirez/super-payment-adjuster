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

use pdaleramirez\superpaymentadjuster\plugin\Routes;
use pdaleramirez\superpaymentadjuster\plugin\Services;
use pdaleramirez\superpaymentadjuster\variables\SuperPaymentAdjusterVariable;
use pdaleramirez\superpaymentadjuster\twigextensions\SuperPaymentAdjusterTwigExtension;
use pdaleramirez\superpaymentadjuster\models\Settings;
use pdaleramirez\superpaymentadjuster\utilities\SuperPaymentAdjusterUtility as SuperPaymentAdjusterUtilityUtility;
use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\services\Utilities;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

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
     * @var SuperPaymentAdjuster
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->_setPluginComponents();
        $this->_registerCpRoutes();
        
        self::$plugin = $this;
        
        Craft::$app->view->registerTwigExtension(new SuperPaymentAdjusterTwigExtension());

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'super-payment-adjuster/default';
            }
        );

        
        
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'super-payment-adjuster/default/do-something';
            }
        );

        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SuperPaymentAdjusterUtilityUtility::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('superPaymentAdjuster', SuperPaymentAdjusterVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'super-payment-adjuster',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
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

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'super-payment-adjuster/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
