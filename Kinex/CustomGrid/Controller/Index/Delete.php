<?php

namespace Kinex\CustomGrid\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\PageCache\Version;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class Delete extends \Magento\Framework\App\Action\Action {
 
    protected $allGridsFactory;

    protected $messageManager;

    protected $cacheTypeList;

   protected $cacheFrontendPool;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,   
        \Kinex\CustomGrid\Model\allGridsFactory $allGridsFactory,
        TypeListInterface $cacheTypeList, 
        Pool $cacheFrontendPool
    ) {
        $this->allGridsFactory = $allGridsFactory;
        $this->messageManager = $messageManager;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
        parent::__construct($context);

    }

    public function execute() 
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $model = $this->allGridsFactory->create();
            $model->load($id);
            $model->delete();
            $this->messageManager->addSuccessMessage(__("Record Delete Successfully."));

        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        } 
        $this->flushCache();

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
 
    }

    public function flushCache()
    {
        $_types = [
            'config',
            'layout',
            'block_html',
            'collections',
            'reflection',
            'db_ddl',
            'eav',
            'config_integration',
            'config_integration_api',
            'full_page',
            'translate',
            'config_webservice'
            ];
 
            foreach ($_types as $type) {
                $this->cacheTypeList->cleanType($type);
            }
            foreach ($this->cacheFrontendPool as $cacheFrontend) {
                $cacheFrontend->getBackend()->clean();
            }
    }

}