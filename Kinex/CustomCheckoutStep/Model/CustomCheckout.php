<?php
namespace Kinex\CustomCheckoutStep\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class CustomCheckout extends AbstractModel 
{
	const CACHE_TAG = 'custom_checkout';

	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Kinex\CustomCheckoutStep\Model\ResourceModel\CustomCheckout');
    }
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
    
   
}
?>