<?php
namespace Kinex\CustomContact\Controller\Adminhtml\ContactUs;
use Magento\Framework\Controller\ResultFactory;

class Sendmail extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	private $helper;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Kinex\CustomContact\Helper\ReplyMail $helper
	
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->helper = $helper;	
	}

	public function execute()
	{   
		$resultRedirect = $this->resultRedirectFactory->create();
		$msg = $this->getRequest()->getParam('send_message');
	    $contactId = $this->getRequest()->getParam('entity_id');
		$model = $this->_objectManager->create(\Kinex\CustomContact\Model\Contactus::class);
        $data =  $model->load($contactId);
		$customerEmail = $model->load($contactId)->getData('email');
        // calling helper for send mail
		$send = $this->helper->sendEmail($msg , $customerEmail);
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
		
	}
}
?>