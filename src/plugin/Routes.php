<?php

namespace pdaleramirez\superpaymentadjuster\plugin;

use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use yii\base\Event;

trait Routes
{
    private function _registerCpRoutes()
    {
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules['super-payment-adjuster/payment-adjusters'] = 'super-payment-adjuster/payment-adjuster/payment-adjuster-index';
            $event->rules['super-payment-adjuster/payment-adjusters/<id:\d+|new>'] = 'super-payment-adjuster/payment-adjuster/edit';
        });
    }
}

