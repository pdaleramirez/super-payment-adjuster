<?php

namespace pdaleramirez\superpaymentadjuster\plugin;

use pdaleramirez\superpaymentadjuster\services\PaymentAdjuster;

/**
 * Trait Services
 * @property PaymentAdjuster $adjuster
 * @package pdaleramirez\superpaymentadjuster
 */
trait Services
{
    public function getPaymentAdjuster(): PaymentAdjuster
    {
        return $this->get('adjuster');    
    }
    
    private function _setPluginComponents()
    {
        $this->setComponents([
            'adjuster' => [
                'class' => PaymentAdjuster::class
            ]
        ]);
    }
}
