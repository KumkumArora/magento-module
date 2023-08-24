<?php

namespace Kinex\CustomGrid\Controller\Adminhtml\Allgrids;
use Magento\Framework\Filesystem;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;

class Delete extends \Magento\Backend\App\Action
{

    protected $_filesystem;
    protected $_file;

    public function __construct(
        Context $context,
        Filesystem $_filesystem,
        File $file
    )
    {
        parent::__construct($context);
        $this->_filesystem = $_filesystem;
        $this->_file = $file;
    }
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Kinex_CustomGrid::grids_delete');
	}
	
	/**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('grid_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Kinex\CustomGrid\Model\Allgrids::class);
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                
                // delete image from directory
                $fileName = $model['image_field'];
                $mediaRootDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(). 'wysiwyg/helloworld/' ;
                if ($this->_file->isExists($mediaRootDir . $fileName)) {
                $this->_file->deleteFile($mediaRootDir . $fileName);
                }

                // display success message
                $this->messageManager->addSuccess(__('The grids has been deleted.'));
                // go to grid
                $this->_eventManager->dispatch(
                    'adminhtml_grids_on_delete',
                    ['title' => $title, 'status' => 'success']
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_grids_on_delete',
                    ['title' => $title, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['grid_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a grids to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
?>
