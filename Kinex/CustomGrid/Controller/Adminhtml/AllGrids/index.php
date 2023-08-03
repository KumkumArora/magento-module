<?php
namespace Kinex\CustomGrid\Controller\Adminhtml\AllGrids;
class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	protected $helperData;

	// Protected $allGridsFactory;
	
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Kinex\CustomGrid\Helper\Data $helperData,
		// \Kinex\CustomGrid\Model\AllgridsFactory $allGridsFactory,

	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->helperData = $helperData;
		// $this->allGridsFactory = $allGridsFactory;
	}

	public function execute()
	{   
		/****************for get values from system configuration**************/

		// echo "hello";
		// print_r('This is my first project');
		// echo $this->helperData->getStorefrontConfig('grid_link');
		// echo $this->helperData->getStorefrontConfig('set_limit');
		// echo $this->helperData->getGeneralConfig('enable');	
		// exit();	

		/* ****************create and get collection data*********************/

		// $allgrids = $this->allGridsFactory->create();
		// $gridsCollection = $allgrids->getCollection();
		// echo '<pre>'; print_r($gridsCollection->getData());
		
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('All Grids'));
		return $resultPage;
	}
}
?>