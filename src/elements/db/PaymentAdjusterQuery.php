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
            Table::PAYMENT_ADJUSTER . '.name',
            Table::PAYMENT_ADJUSTER . '.handle',
            Table::PAYMENT_ADJUSTER . '.description',
            Table::PAYMENT_ADJUSTER . '.gatewayHandle',
            Table::PAYMENT_ADJUSTER . '.method',
            Table::PAYMENT_ADJUSTER . '.type',
            Table::PAYMENT_ADJUSTER . '.amountType',
            Table::PAYMENT_ADJUSTER . '.baseAmount',
            Table::PAYMENT_ADJUSTER . '.percentAmount'
        ]);

        return parent::beforePrepare();
    }
}
