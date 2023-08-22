<?php
namespace Kinex\CustomCheckoutStep\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class CustomCheckout extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	/**
     * Define main table
     */
	protected function _construct()
	{
		$this->_init('custom_checkout', 'id');
	}
	
	
}
?>