<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\migrations;

use Craft;
use craft\db\Migration;
use pdaleramirez\superpaymentadjuster\db\Table;
use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster;

/**
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTables();
        $this->createIndexes();

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTableIfExists(Table::PAYMENT_ADJUSTER);

        return true;
    }

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema(Table::PAYMENT_ADJUSTER);
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                Table::PAYMENT_ADJUSTER,
                [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(),
                    'handle' => $this->string(),
                    'description' => $this->text(),
                    'gatewayHandle' => $this->string(),
                    'method' => $this->string()->defaultValue('paymentAdjusterMethodAdd'),
                    'type' => $this->string()->defaultValue('shipping'),
                    'amountType' => $this->string()->defaultValue('baseAmount'),
                    'baseAmount' => $this->decimal(14, 4)->notNull()->defaultValue(0),
                    'percentAmount' => $this->decimal(14, 4)->notNull()->defaultValue(0),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid()
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(null, Table::PAYMENT_ADJUSTER, 'handle', true);
    }
}
