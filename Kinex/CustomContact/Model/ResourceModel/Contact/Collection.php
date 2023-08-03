<?php
namespace Kinex\CustomContact\Model\ResourceModel\Contact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
    {
        $this->_init(
            'Kinex\CustomContact\Model\Contactus',
            'Kinex\CustomContact\Model\ResourceModel\Contactus'
        );
        parent::_construct();
    }
}
?>