<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace pdaleramirez\superpaymentadjuster\elements\db;

use craft\elements\db\ElementQuery;
use pdaleramirez\superpaymentadjuster\db\Table;


class PaymentAdjusterQuery extends ElementQuery
{
    
    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        $this->joinElementTable(Table::PAYMENT_ADJUSTER);

        $this->query->select([
            Table::PAYMENT_ADJUSTER . '.id',
            Table::PAYMENT_ADJUSTER . '.handle',
            Table::PAYMENT_ADJUSTER . '.gatewayHandle'
        ]);
        
        return parent::beforePrepare();
    }
}
