<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\services;

use craft\commerce\adjusters\Discount;
use craft\commerce\adjusters\Shipping;
use craft\commerce\adjusters\Tax;
use craft\base\Component;

/**
 * Class PaymentAdjuster
 * @package pdaleramirez\superpaymentadjuster\services
 * @author    Dale Ramirez
 * @since     1.0.0
 */
class PaymentAdjuster extends Component
{
    public function getTypes(): array
    {
        return [
            Shipping::ADJUSTMENT_TYPE,
            Discount::ADJUSTMENT_TYPE,
            Tax::ADJUSTMENT_TYPE
        ];
    }
}
