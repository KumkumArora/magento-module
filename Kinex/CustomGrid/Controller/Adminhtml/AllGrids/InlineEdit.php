<?php
namespace Kinex\CustomGrid\Controller\Adminhtml\Allgrids;

use Magento\Backend\App\Action\Context;
use Kinex\CustomGrid\Api\AllgridsRepositoryInterface as AllgridsRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Kinex\CustomGrid\Api\Data\AllgridsInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $allgridsRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        AllgridsRepository $allgridsRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->allgridsRepository = $allgridsRepository;
        $this->jsonFactory = $jsonFactory;
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
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $gridId) {
            $grids = $this->allgridsRepository->getById($gridId);
            try {
                $gridsData = $postItems[$gridId];
                $extendedGridsData = $grids->getData();
                $this->setGridsData($grids, $extendedGridsData, $gridsData);
                $this->allgridsRepository->save($grids);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithGridsId($grids, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithGridsId($grids, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithGridsId(
                    $grids,
                    __('Something went wrong while saving the grids.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithGridsId(AllgridsInterface $grids, $errorText)
    {
        return '[Grid ID: ' . $grids->getId() . '] ' . $errorText;
    }

    public function setGridsData(\Kinex\CustomGrid\Model\Allgrids $grids, array $extendedGridsData, array $gridsData)
    {
        $grids->setData(array_merge($grids->getData(), $extendedGridsData, $gridsData));
        return $this;
    }
}
?>