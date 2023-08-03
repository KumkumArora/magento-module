<?php
namespace Kinex\CustomContact\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('contact_us'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false, 'default' => ''],
                'Name'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false, 'default' => ''],
                'Email'
            )
            ->addColumn(
                'phone_number',
                Table::TYPE_INTEGER,
                11,
                [],
                'PhoneNumber'
            )
            ->addColumn(
              'subject',
              Table::TYPE_TEXT,
              null,
              ['nullable' => false, 'default' => ''],
              'Subject'
           ) 
           ->addColumn(
             'comment',
             Table::TYPE_TEXT,
             null,
             ['nullable' => false, 'default' => ''],
             'Comments'
            )
            ->setComment('Contact Us Table');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}