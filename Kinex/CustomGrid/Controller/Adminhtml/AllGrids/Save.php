<?php

namespace Kinex\CustomGrid\Controller\Adminhtml\Allgrids;

use Magento\Backend\App\Action;
use Kinex\CustomGrid\Model\Allgrids;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Redirect;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Kinex\CustomGrid\Model\AllgridsFactory
     */
    private $allgridsFactory;

    /**
     * @var \Kinex\CustomGrid\Api\AllgridsRepositoryInterface
     */
    private $allgridsRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Kinex\CustomGrid\Model\AllgridsFactory $allgridsFactory
     * @param \Kinex\CustomGrid\Api\AllgridsRepositoryInterface $allgridsRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Kinex\CustomGrid\Model\AllgridsFactory $allgridsFactory = null,
        \Kinex\CustomGrid\Api\AllgridsRepositoryInterface $allgridsRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
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

            $model->setData($data);

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
}
?>