<?php
namespace Kinex\CustomCheckoutStep\Model\ResourceModel\Checkout;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
	/**
     * Define model & resource model
     */
	protected function _construct()
    {
        $this->_init(
            'Kinex\CustomCheckoutStep\Model\CustomCheckout',
            'Kinex\CustomCheckoutStep\Model\ResourceModel\CustomCheckout'
        );
        parent::_construct();
    }
}
?>