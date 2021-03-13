<?php

use Codeception\Test\Unit;
use craft\commerce\elements\Order;
use pdaleramirez\superpaymentadjuster\elements\PaymentAdjuster as PaymentAdjusterElement;
use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster as PaymentAdjusterRecord;
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
    
    public function testAdjustmentTotal()
    {
        /** @var Order $order */
        $order = $this->make(Order::class, ['getTotal' => 100]);
        
        $paymentAdjuster = new PaymentAdjusterElement();
        $paymentAdjuster->gatewayHandle = 'dummy';
        $paymentAdjuster->baseAmount = 20;
        $paymentAdjuster->amountType = PaymentAdjusterRecord::AMOUNT_FLAT;
        $paymentAdjuster->method = PaymentAdjusterRecord::METHOD_DEDUCT;
        
        $amount = $this->paymentAdjuster->getAdjustmentTotal($order, $paymentAdjuster);
        self::assertEquals(-20, $amount);
        
        $paymentAdjuster->method = PaymentAdjusterRecord::METHOD_ADD;
        $amount = $this->paymentAdjuster->getAdjustmentTotal($order, $paymentAdjuster);
        self::assertEquals(20, $amount);
        
        $paymentAdjuster->amountType = PaymentAdjusterRecord::AMOUNT_PERCENT;
        $paymentAdjuster->percentAmount = 35;
        $amount = $this->paymentAdjuster->getAdjustmentTotal($order, $paymentAdjuster);
        self::assertEquals(35.0, $amount);
    }
}
