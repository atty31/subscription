<?php

namespace Atty31\Subscription\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $this->createSubscriptionTable($installer);
        $this->createSubscriptionQuoteTable($installer);

        $installer->endSetup();
    }

    /**
     * Create subscription table
     * @param $installer
     */
    public function createSubscriptionTable($installer)
    {
        $tableName = $installer->getTable('atty31_subscription');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create atty31_subscription table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Customer id'
                )
                ->addColumn(
                    'original_order_entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Order entity id'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Updated At'
                )
                ->addColumn(
                    'scheduled_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Scheduled At'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
                ->addIndex(
                    $installer->getIdxName(
                        $tableName,
                        ['original_order_entity_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['original_order_entity_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->setComment('Subscription table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
    }

    /**
     * Create subscription quote table
     * @param $installer
     */
    public function createSubscriptionQuoteTable($installer)
    {
        $tableName = $installer->getTable('atty31_subscription_quote');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create atty31_subscription_quote table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'subscription_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Subscription id'
                )
                ->addColumn(
                    'quote_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Quote id'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                            )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Updated At'
                )
                ->addColumn(
                    'admin_user_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Admin user id'
                )
                ->setComment('Subscription quote table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
    }
}