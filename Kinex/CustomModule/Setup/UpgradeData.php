<?php
namespace Kinex\CustomModule\Setup;

use Magento\Framework\Setup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class UpgradeData implements UpgradeDataInterface 
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;
    /**
     * @param EavSetupFactory  $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context
    ) { 

		$setup->startSetup();

        if(version_compare($context->getVersion(), '1.2.1', '<')) {
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);
        $statusOptions = 'Kinex\CustomModule\Model\Config\Source\StatusOptions';
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'Product_availability',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Product Availability',
                'input' => 'select',
                'class' => '',
                'source' => $statusOptions,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'is_used_in_grid' => true,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );

     }
    $setup->endSetup();
    }
}