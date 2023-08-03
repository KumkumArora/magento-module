<?php
namespace Kinex\CustomContact\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Contactus extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	/**
     * Define main table
     */
	protected function _construct()
	{
		$this->_init('contact_us', 'entity_id');
	}
	
	
}
?>