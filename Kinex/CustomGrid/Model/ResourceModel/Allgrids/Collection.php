<?php
namespace Kinex\CustomGrid\Model\ResourceModel\Allgrids;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'grid_id';
	
	protected $_eventPrefix = 'grids_allgrids_collection';

    protected $_eventObject = 'allgrids_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Kinex\CustomGrid\Model\Allgrids', 'Kinex\CustomGrid\Model\ResourceModel\Allgrids');
	}
}
?>