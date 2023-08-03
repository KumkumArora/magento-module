<?php
namespace Kinex\CustomGrid\Controller\Index;

class Event extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
	
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{  
		$textDisplay = new \Magento\Framework\DataObject(array('text' => 'Kinex Media'));
		$this->_eventManager->dispatch('kinex_customgrid_display_text', ['mp_text' => $textDisplay]);
		echo $textDisplay->getText();
		exit;
	}
}
