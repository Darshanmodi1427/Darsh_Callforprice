<?php
namespace Darsh\Callforprice\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class InstallSchema
 * @package Darsh\Callforprice\Setup
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists('darsh_callprice')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('darsh_callprice'));
            $table->addColumn(
                'id', Table::TYPE_INTEGER, null, [
                'auto_increment' => true,
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], 'Id'
            )
                ->addColumn(
                    'customer_name', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Name'
                )
                ->addColumn(
                    'customer_email', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Email'
                )
                ->addColumn(
                    'customer_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false,], 'Customer ID'
                )
                ->addColumn(
                    'customer_telephone', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Customer Telephone'
                )
                ->addColumn(
                    'product_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false,], 'Product ID'
                )
                ->addColumn(
                    'product_name', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Product Name'
                )
                ->addColumn(
                    'status', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => ''], 'Product Name'
                )
                ->setComment('Darsh Call Price');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
