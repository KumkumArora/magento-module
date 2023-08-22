<?php
namespace Kinex\CustomCheckoutStep\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{  /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context )
    {
        $installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.2.0', '<')) {

		if (!$installer->tableExists('custom_checkout')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('custom_checkout')
			)
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'text_field',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false, 'default' => ''],
                'text'
            )
            ->addColumn(
                'select_field',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false, 'default' => ''],
                'Select'
            )
           ->addColumn(
             'date_field',
             Table::TYPE_DATETIME,
             null,
             ['nullable' => false],
             'Date'
            )
            ->setComment('Checkout Form Table');
        $installer->getConnection()->createTable($table);
        }
    } 


    if(version_compare($context->getVersion(), '1.2.1', '<')) {

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'text_field',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'default' => '',
                'comment' => 'Text'
            ]
        );

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'text_field',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'default' => '',
                'comment' => 'Text'
            ]
        );

      }

      if(version_compare($context->getVersion(), '1.2.2', '<')) {

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'select_field',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'default' => '',
                'comment' => 'Select'
            ]
        );

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'select_field',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'default' => '',
                'comment' => 'Select'
            ]
        );


        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'date_field',
            [
                'type' => Table::TYPE_DATETIME,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Date'
            ]
        );

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'date_field',
            [
                'type' => Table::TYPE_DATETIME,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Date'
            ]
        );

      }

      if(version_compare($context->getVersion(), '1.2.3', '<')) {

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'date_field',
            [
                'type' => Table::TYPE_DATETIME,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Date'
            ]
        );

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'select_field',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'default' => '',
                'comment' => 'Select'
            ]
        );

        $table = $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'text_field',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'default' => '',
                'comment' => 'Text'
            ]
        );

      } 

      if(version_compare($context->getVersion(), '1.2.5', '<')) {

            $table = $installer->getConnection()->addColumn(
                $installer->getTable('quote'),
                'checkbox_field',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'comment' => 'Checkbox'
                ]
            );
    
            $table = $installer->getConnection()->addColumn(
                $installer->getTable('sales_order'),
                'checkbox_field',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'comment' => 'Checkbox'
                ]
            );
    
            $table = $installer->getConnection()->addColumn(
                $installer->getTable('sales_order_grid'),
                'checkbox_field',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'comment' => 'Checkbox'
                ]
            );
    
            $table = $installer->getConnection()->addColumn(
                $installer->getTable('custom_checkout'),
                'checkbox_field',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'comment' => 'Checkbox'
                ]
            );
        }

        $installer->endSetup();
    }
}




