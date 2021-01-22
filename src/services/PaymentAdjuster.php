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

use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster as PaymentAdjusterRecord;
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
          PaymentAdjusterRecord::TYPE_ORDER,  
          PaymentAdjusterRecord::TYPE_SHIPPING  
        ];
    }
}
