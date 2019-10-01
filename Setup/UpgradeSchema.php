<?php

namespace Darsh\Callforprice\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class UpgradeSchema
 * @package Darsh\Callforprice\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {

            $tableName = $setup->getTable('darsh_callprice');
            $connection = $setup->getConnection();
            $connection->addColumn(
                $tableName,
                'email_sent',
                ['type' => Table::TYPE_TEXT, 'nullable' => false, 'afters' => 'status', 'length' => 255,'default' => '0', 'comment' => 'Email Sent']
            );
              $connection->addColumn(
                $tableName,
                'request_detail',
                ['type' => Table::TYPE_TEXT, 'nullable' => true, 'afters' => 'email_sent', 'length' => '2M','default' => '', 'comment' => 'Request Details']
            );
        }

        $setup->endSetup();
    }
}