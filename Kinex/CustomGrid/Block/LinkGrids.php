<?php
namespace Kinex\CustomGrid\Block;

Class LinkGrids extends \Magento\Framework\View\Element\Template
{
	protected $dataHelper;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Kinex\CustomGrid\Helper\Data $dataHelper,
		
	){
		parent::__construct($context);
		$this->dataHelper = $dataHelper;
	}
	
	public function getGridsLink()
	{
		return "Latest Grids";
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
?>