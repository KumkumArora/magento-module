<?php

namespace Kinex\CustomModule\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface ;
use Magento\Sales\Api\OrderRepositoryInterface;

class SendOrderMailToAdmin implements ObserverInterface
{

    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $orderRepository;

    public function __construct(
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->scopeConfig = $scopeConfig;
        $this->orderRepository = $orderRepository;
        $this->transportBuilder = $transportBuilder;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {   
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getID();
        $orderid=$order->getEntityId();

        foreach ($order->getAllItems() as $item) {
            $ProdustSku[] = $item->getSku();
            $proName[] = $item->getName(); //product name
        }
        $proName = json_encode($proName);
        $ProdustSku = json_encode($ProdustSku);
        $customerId = $order->getCustomerId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
        $name = $customer->getName();
        $total=$order->getGrandTotal();
        
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Magento'),
                'email' => $this->escaper->escapeHtml('kumkum.infino@gmail.com'),
            ];
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_demo_order')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'orderid'     => $orderid,
                    'customerName'=> $name,
                    'productname' => $proName,
                    'productsku'  => $ProdustSku,
                    'total'       => $total,   
                ])
                ->setFrom($sender)
                ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
        }
    }

}