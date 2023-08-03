<?php
namespace Kinex\CustomGrid\Block\Adminhtml\Allgrids\Edit;

use Magento\Backend\Block\Widget\Context;
use Kinex\CustomGrid\Api\AllgridsRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allgridsRepository;
    
    public function __construct(
        Context $context,
        AllgridsRepositoryInterface $allgridsRepository
    ) {
        $this->context = $context;
        $this->allgridsRepository = $allgridsRepository;
    }

    public function getGridId()
    {
        try {
            return $this->allgridsRepository->getById(
                $this->context->getRequest()->getParam('grid_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
?>