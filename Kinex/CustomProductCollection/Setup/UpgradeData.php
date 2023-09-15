<?php
namespace Kinex\CustomProductCollection\Setup;

use Magento\Framework\Setup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class UpgradeData implements UpgradeDataInterface 
{
     /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;


    public function __construct(
       
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context
    ) { 

		$setup->startSetup();

        if(version_compare($context->getVersion(), '1.0.3', '<')) {
       /** @var CustomerSetup $customerSetup */

       $statusOptions = 'Kinex\CustomProductCollection\Model\Config\Source\StatusOptions';
       $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

       $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
       $attributeSetId = $customerEntity->getDefaultAttributeSetId();

       /** @var $attributeSet AttributeSet */
       $attributeSet = $this->attributeSetFactory->create();
       $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

       $customerSetup->addAttribute(Customer::ENTITY, 'register_as_a', [

           'type'           => 'text',
           'label'          => 'Account Register as a',
           'input'          => 'select',
           'source'         => $statusOptions,
           'frontend'       => '',
           'required'       => false,
           'backend'        => '',
           'default'        => null,
           'sort_order'     => 210,
           'visible'        => false,
           'system'         => false,
           'position'       => 210,
           'admin_checkout' => 1,
       ]);

       $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'register_as_a')
       ->addData([
           'attribute_set_id' => $attributeSetId,
           'attribute_group_id' => $attributeGroupId,
           'used_in_forms' => ['adminhtml_customer','customer_account_create','customer_account_edit'],
       ]);

       $attribute->save();

     }
    
    $setup->endSetup();
    }
}