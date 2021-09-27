<?php

namespace Dev\Custom\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
   private $customerSetupFactory;
     /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
   public function __construct(\Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory,
   AttributeSetFactory $attributeSetFactory)
   {
       $this->customerSetupFactory = $customerSetupFactory;
       $this->attributeSetFactory = $attributeSetFactory;
   }

   public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
   {
       $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

       $customerAddressEntity = $customerSetup->getEavConfig()->getEntityType('customer_address');
        $attributeSetId = $customerAddressEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

       if (version_compare($context->getVersion(), '1.0.1') < 0) {
           $customerSetup->addAttribute('customer_address', 'custom_field', [
               'label' => 'Custom Field',
               'input' => 'text',
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'source' => '',
               'required' => false,
               'position' => 90,
               'visible' => true,
               'system' => false,
               'is_used_in_grid' => false,
               'is_visible_in_grid' => false,
               'is_filterable_in_grid' => false,
               'is_searchable_in_grid' => false,
               'frontend_input' => 'hidden',
               'backend' => ''
           ]);

              $attribute=$customerSetup->getEavConfig()
                ->getAttribute('customer_address','custom_field')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => [
                    'adminhtml_customer_address',
                    'adminhtml_customer',
                    'customer_address_edit',
                    'customer_register_address',
                    'customer_address',
                ]                             
                ]);
           $attribute->save();
       }
   }
}