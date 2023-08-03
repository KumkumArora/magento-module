<?php

namespace Kinex\CustomGrid\Model;

use Kinex\CustomGrid\Api\Data;
use Kinex\CustomGrid\Api\AllgridsRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Kinex\CustomGrid\Model\ResourceModel\Allgrids as ResourceAllgrids;
use Kinex\CustomGrid\Model\ResourceModel\Allgrids\CollectionFactory as AllgridsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AllgridsRepository implements AllgridsRepositoryInterface
{
    protected $resource;

    protected $allgridsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllgridsFactory;

    private $storeManager;

    public function __construct(
        ResourceAllgrids $resource,
        AllgridsFactory $allgridsFactory,
        Data\AllgridsInterfaceFactory $dataAllgridsFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->allgridsFactory = $allgridsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllgridsFactory = $dataAllgridsFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Kinex\CustomGrid\Api\Data\AllgridsInterface $grids)
    {
        if ($grids->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $grids->setStoreId($storeId);
        }
        try {
            $this->resource->save($grids);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the grid: %1', $exception->getMessage()),
                $exception
            );
        }
        return $grids;
    }

    public function getById($gridId)
    {
		$grids = $this->allgridsFactory->create();
        $grids->load($gridId);
        if (!$grids->getId()) {
            throw new NoSuchEntityException(__('Grids with id "%1" does not exist.', $gridId));
        }
        return $grids;
    }
	
    public function delete(\Kinex\CustomGrid\Api\Data\AllgridsInterface $grids)
    {
        try {
            $this->resource->delete($grids);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the grids: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($gridId)
    {
        return $this->delete($this->getById($gridId));
    }
}
?>