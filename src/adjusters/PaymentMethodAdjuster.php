<?php

namespace pdaleramirez\superpaymentadjuster\adjusters;

use Craft;
use craft\base\Component;
use craft\commerce\base\AdjusterInterface;
use craft\commerce\elements\Order;
use craft\commerce\models\OrderAdjustment;
use pdaleramirez\superpaymentadjuster\elements\PaymentAdjuster;
use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster as PaymentAdjusterRecord;

class PaymentMethodAdjuster extends Component implements AdjusterInterface
{
    public function adjust(Order $order): array
    {
        $adjustments = [];

        if ($order->getGateway() !== null) {
            $gatewayHandle = $order->getGateway()->handle;

            $gateways = PaymentAdjuster::find()->status('enabled')
                ->where(['gatewayHandle' => $gatewayHandle])->all();

            /** @var PaymentAdjuster $gateway */
            foreach ($gateways as $gateway) {
                $adjustment = new OrderAdjustment;
                $adjustment->type = $gateway->type;
                $adjustment->name = $gateway->name;
                $adjustment->description = $gateway->description;

                $amount = $gateway->baseAmount;
                if ($gateway->amountType === PaymentAdjusterRecord::AMOUNT_PERCENT) {
                    $amount = $order->getTotal() * ($gateway->percentAmount / 100);
                }

                $total = $amount;
                if ($gateway->method === PaymentAdjusterRecord::METHOD_DEDUCT) {
                    $total = $amount * -1;
                }
                $adjustment->name = $gateway->name;
                $adjustment->amount = $total;
                $adjustment->setOrder($order);

                $adjustments[] = $adjustment;

            }
        }

        return $adjustments;
    }
}
