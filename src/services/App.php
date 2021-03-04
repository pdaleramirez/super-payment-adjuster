<?php

namespace pdaleramirez\superpaymentadjuster\services;


use craft\base\Component;

class App extends Component
{
    /** @var PaymentAdjuster $paymentAdjuster */
    public $paymentAdjuster;
    
    public function init()
    {
        $this->paymentAdjuster = new PaymentAdjuster();
    }
}
