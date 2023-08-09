<?php
namespace Kinex\CustomContact\Model\ResourceModel\Contact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected $_eventPrefix = 'Kinex_CustomContact_grid_collection';

    protected $_eventObject = 'Kinex_CustomContact_collection';
	
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