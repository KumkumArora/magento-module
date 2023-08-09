<?php

namespace Kinex\CustomContact\Controller\Adminhtml\ContactUs;

class Delete extends \Magento\Backend\App\Action
{	
	/**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    { 
        $id = $this->getRequest()->getParam('entity_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Kinex\CustomContact\Model\Contactus::class);
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                $this->messageManager->addSuccess(__('The grids has been deleted.'));
                return $resultRedirect->setPath('*/*/');

            } catch (\Exception $e) {
               
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->messageManager->addError(__('We can\'t find a grids to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
?>
