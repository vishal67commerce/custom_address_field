<?php
namespace Dev\Custom\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
		SchemaSetupInterface $setup, 
		ModuleContextInterface $context
	){
        
		$installer = $setup;
        $installer->startSetup();
        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'custom_field',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Custom Field',
            ]
        );
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'custom_field',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Custom Field',
            ]
        );

		$installer->getConnection()->addColumn(
            $installer->getTable('quote_address'),
            'custom_field',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Custom Field',
            ]
        );
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_address'),
            'custom_field',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Custom Field',
            ]
        );

        $setup->endSetup();
    }
}