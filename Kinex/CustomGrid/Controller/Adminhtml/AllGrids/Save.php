<?php

namespace Kinex\CustomGrid\Controller\Adminhtml\Allgrids;

use Magento\Backend\App\Action;
use Kinex\CustomGrid\Model\Allgrids;
use Kinex\CustomGrid\Model\ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    
    /**
     * @var \Kinex\CustomGrid\Model\ImageUploader
     */
    private $imageUploaderModel;

    /**
     * @var \Kinex\CustomGrid\Api\AllgridsRepositoryInterface
     */
    private $allgridsRepository;

    protected $_filesystem;
    protected $_file;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param \Kinex\CustomGrid\Model\AllgridsFactory $allgridsFactory
     * @param \Kinex\CustomGrid\Api\AllgridsRepositoryInterface $allgridsRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploaderModel,
        Manager $cacheManager,
        Filesystem $_filesystem,
        File $file,
        \Kinex\CustomGrid\Model\AllgridsFactory $allgridsFactory = null,
        \Kinex\CustomGrid\Api\AllgridsRepositoryInterface $allgridsRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploaderModel = $imageUploaderModel;
        $this->cacheManager = $cacheManager;
        $this->_filesystem = $_filesystem;
        $this->_file = $file;
        $this->allgridsFactory = $allgridsFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Kinex\CustomGrid\Model\AllgridsFactory::class);
        $this->allgridsRepository = $allgridsRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Kinex\CustomGrid\Api\AllgridsRepositoryInterface::class);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	// protected function _isAllowed()
	// {
	// 	return $this->_authorization->isAllowed('Kinex_CustomGrid::save');
	// }
        
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Allgrids::STATUS_ENABLED;
            }
            if (empty($data['grid_id'])) {
                $data['grid_id'] = null;
            }

            /** @var \Kinex\CustomGrid\Model\Allgrids $model */
            $model = $this->allgridsFactory->create();

            $id = $this->getRequest()->getParam('grid_id');
            if ($id) {
                try {
                    $model = $this->allgridsRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This grids no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model = $this->imageData($model, $data);
            $this->_eventManager->dispatch(
                'grids_allgrids_prepare_save',
                ['allgrids' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allgridsRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the grids.'));
                $this->dataPersistor->clear('grids_allgrids');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['grid_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the grids.'));
            }

            $this->dataPersistor->set('grids_allgrids', $data);
            return $resultRedirect->setPath('*/*/edit', ['grid_id' => $this->getRequest()->getParam('grid_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $model
     * @param $data
     * @return mixed
     */
    public function imageData($model, $data)
    {
        if ($model->getId()) {
            $pageData = $this->allgridsFactory->create();
            $pageData->load($model->getId());
            if (isset($data['image_field'][0]['name'])) {
                
                // Remove old image from directory
                $oldImage = $pageData['image_field'];
                $mediaRootDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(). 'wysiwyg/helloworld/' ;
                if ($this->_file->isExists($mediaRootDir . $oldImage)) {
                $this->_file->deleteFile($mediaRootDir . $oldImage);
                }
                $imageName1 = $pageData->getThumbnail();
                $imageName2 = $data['image_field'][0]['name'];
                if ($imageName1 != $imageName2) {
                    $imageUrl = $data['image_field'][0]['url'];
                    $imageName = $data['image_field'][0]['name'];
                    $data['image_field'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
                } else {
                    $data['image_field'] = $data['image_field'][0]['name'];
                }
            } else {
                $data['image_field'] = '';
            }
        } else {
            if (isset($data['image_field'][0]['name'])) {
                $imageUrl = $data['image_field'][0]['url'];
                $imageName = $data['image_field'][0]['name'];
                $data['image_field'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
            }
        }
        $model->setData($data);
        return $model;
    }
}
?>