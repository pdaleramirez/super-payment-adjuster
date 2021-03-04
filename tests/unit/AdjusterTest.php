<?php

use Codeception\Test\Unit;
use pdaleramirez\superpaymentadjuster\services\PaymentAdjuster;
use pdaleramirez\superpaymentadjuster\SuperPaymentAdjuster;

class AdjusterTest extends Unit
{
    /** @var PaymentAdjuster $paymentAdjuster */
    protected $paymentAdjuster;
    
    protected function _before()
    {
        parent::_before();
        
        $this->paymentAdjuster = SuperPaymentAdjuster::$app->paymentAdjuster;
    }
    
    public function testThis()
    {
        $types = $this->paymentAdjuster->getTypes();
        self::assertTrue(true);
    }
}
