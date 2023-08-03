<?php
namespace Kinex\CustomGrid\Block;

Class ListGrids extends \Magento\Framework\View\Element\Template
{
	protected $allGridsFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Kinex\CustomGrid\Model\allGridsFactory $allGridsFactory
	){
		parent::__construct($context);
		$this->allGridsFactory = $allGridsFactory;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListGrids()
	{
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 5;
		
		$collection = $this->allGridsFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		$collection->setCurPage($page);
	
		return $collection;
	}
	
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$this->pageConfig->getTitle()->set(__('Latest Grids'));
		
		if ($this->getListGrids()){
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'kinex.customgrid.pager')
									->setAvailableLimit(array(5=>5,10=>10,15=>15,20=>20))
									->setShowPerPage(true)
									->setCollection($this->getListGrids());

			$this->setChild('pager', $pager);

			$this->getListGrids()->load();
		}
        return $this;
	}
	
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
}
?>