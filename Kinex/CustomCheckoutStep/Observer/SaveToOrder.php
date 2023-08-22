<?php
namespace Kinex\CustomCheckoutStep\Observer;

class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{   
    protected $_logger;

    protected $customcheckoutFactory; 

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Kinex\CustomCheckoutStep\Model\CustomCheckoutFactory $customcheckoutFactory
    ) {
        $this->_logger = $logger;
        $this->customcheckoutFactory = $customcheckoutFactory; 
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
    	$order = $event->getOrder();
           //store data in sales_order table and the same to be added in sales_order_grid table using di.xml 
           $order->setData('text_field', $quote->getData('text_field'));
           $order->setData('select_field', $quote->getData('select_field'));
           $order->setData('date_field', $quote->getData('date_field'));
           $order->setData('checkbox_field', $quote->getData('checkbox_field'));
            

           // store data in custom_checkout table
            $model = $this->customcheckoutFactory->create();
            $model->setData('text_field', $quote->getData('text_field'));
            $model->setData('select_field', $quote->getData('select_field'));
            $model->setData('date_field', $quote->getData('date_field'));
            $model->setData('checkbox_field', $quote->getData('checkbox_field'));
            $model->save();
    }
}