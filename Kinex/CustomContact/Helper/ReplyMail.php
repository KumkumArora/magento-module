<?php
namespace Kinex\CustomContact\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\App\Config\ScopeConfigInterface ;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Controller\Result\Redirect;
use \Magento\Framework\Message\ManagerInterface;
 

class ReplyMail extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $messageManager;
    
    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $context->getLogger();
        $this->messageManager = $messageManager;
       
    }

    public function sendEmail($msg , $customerEmail)
    {   
         try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Magento'),
                'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT)
            ];
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_demo_contact')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'msg'     => $msg,
                ])
                ->setFrom($sender)
                ->addTo($customerEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage(__('Reply Sent successfully to customer'));
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your request. Please try again later.')
            );
        }
       

    }
}
