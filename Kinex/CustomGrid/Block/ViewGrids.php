<?php
namespace Kinex\CustomGrid\Block;

Class ViewGrids extends \Magento\Framework\View\Element\Template
{
	protected $allGridsFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Kinex\CustomGrid\Model\allGridsFactory $allGridsFactory
	){
		parent::__construct($context);
		$this->allGridsFactory = $allGridsFactory;
	}
	
	public function getGrids()
	{
		$id = $this->getRequest()->getParam('id');
		$grids = $this->allGridsFactory->create()->load($id);
		
		return $grids;
	}
	
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
		
		$grids = $this->getGrids();
		$this->pageConfig->getTitle()->set($grids->getTitle());
		
        return $this;
	}
}
?>