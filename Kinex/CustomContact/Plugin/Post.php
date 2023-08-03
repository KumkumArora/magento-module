<?php

namespace Kinex\CustomContact\Plugin;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Kinex\CustomContact\Model\Contactus;

class Post {

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;
    protected $resultPageFactory;

    /**
     * @var \Kinex\CustomContact\Model\AllgridsFactory
     */
    private $ContactusFactory;


    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager, 
        \Kinex\CustomContact\Model\ContactusFactory $ContactusFactory = null,  
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Context $context
    ) {
        
        $this->messageManager = $messageManager;
        $this->contactusFactory  = $ContactusFactory;
        $this->resultPageFactory = $resultPageFactory;
        
    }
    public function aroundExecute(\Magento\Contact\Controller\Index\Post $subject,\Closure $proceed)
    { 
        try {
            $data = (array)$this->getRequest()->getPost();
            dd($data);
            if ($data) {
                $model = $this->ContactusFactory->create();
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't submit your request, Please try again."));
        }                 

        return $proceed();
    }
}