<?php

namespace pdaleramirez\superpaymentadjuster\services;


use craft\base\Component;

class App extends Component
{
    public PaymentAdjuster $paymentAdjuster;
    
    public function init(): void
    {
        $this->paymentAdjuster = new PaymentAdjuster();
    }
}
