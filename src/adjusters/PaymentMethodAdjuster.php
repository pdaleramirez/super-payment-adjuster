<?php

namespace pdaleramirez\superpaymentadjuster\adjusters;

use Craft;
use craft\base\Component;
use craft\commerce\base\AdjusterInterface;
use craft\commerce\elements\Order;
use craft\commerce\models\OrderAdjustment;
use pdaleramirez\superpaymentadjuster\elements\PaymentAdjuster;
use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster as PaymentAdjusterRecord;
use pdaleramirez\superpaymentadjuster\SuperPaymentAdjuster;

class PaymentMethodAdjuster extends Component implements AdjusterInterface
{
    public function adjust(Order $order): array
    {
        $adjustments = [];

        if ($order->getGateway() !== null) {
            $gatewayHandle = $order->getGateway()->handle;

            $paymentAdjusters = PaymentAdjuster::find()->status('enabled')
                ->where(['gatewayHandle' => $gatewayHandle])->all();

            /** @var PaymentAdjuster $paymentAdjuster */
            foreach ($paymentAdjusters as $paymentAdjuster) {
                $adjustment = new OrderAdjustment;
                $adjustment->type = $paymentAdjuster->type;
                $adjustment->name = $paymentAdjuster->name;
                $adjustment->description = $paymentAdjuster->description;


                $adjustment->name = $paymentAdjuster->name;
                $adjustment->amount = SuperPaymentAdjuster::$app->paymentAdjuster->getAdjustmentTotal($order, $paymentAdjuster);
                $adjustment->setOrder($order);

                $adjustments[] = $adjustment;

            }
        }

        return $adjustments;
    }
}
