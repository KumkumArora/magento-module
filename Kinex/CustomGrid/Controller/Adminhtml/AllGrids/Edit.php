<?php

namespace Kinex\CustomGrid\Controller\Adminhtml\Allgrids;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;



    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
        
        
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
       
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Kinex_CustomGrid::save');
	}

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Allgrids
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allgrids $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Kinex_CustomGrid::kinex_customgrid')
            ->addBreadcrumb(__('Grids'), __('Grids'))
            ->addBreadcrumb(__('Manage All Grids'), __('Manage All Grids'));
        return $resultPage;
    }

    /**
     * Edit Allgrids
     *
     * @return \Magento\Backend\Model\View\Result\Allgrids|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('grid_id');
        $model = $this->_objectManager->create(\Kinex\CustomGrid\Model\Allgrids::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('kinex_customgrid', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allgrids $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Grids') : __('Add Grids'),
            $id ? __('Edit Grids') : __('Add Grids')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('All Student Record'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Grids'));

        return $resultPage;
    }
}
?>
