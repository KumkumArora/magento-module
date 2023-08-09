<?php
namespace Kinex\CustomContact\Block;

Class ViewContact extends \Magento\Framework\View\Element\Template
{
	protected $contactUsFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Kinex\CustomContact\Model\ContactusFactory $contactUsFactory
	){
		parent::__construct($context);
		$this->contactUsFactory = $contactUsFactory;
	}
	
	public function getContactquery()
	{
		$id = $this->getRequest()->getParam('entity_id');
		$contact = $this->contactUsFactory->create()->load($id);
		
		return $contact;
	}
	
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
		
		$contact = $this->getContactquery();
		$this->pageConfig->getTitle()->set($contact->getTitle());
		
        return $this;
	}
}
?>