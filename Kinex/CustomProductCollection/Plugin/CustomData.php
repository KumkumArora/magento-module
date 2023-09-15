<?php
namespace Kinex\CustomProductCollection\Plugin;

class CustomData
{
	/**
 	* @var \Magento\Customer\Model\Session
 	*/
	protected $customerSession;

	/**
 	* @var \Magento\Framework\App\Http\Context
 	*/
	protected $httpContext;
	protected $logger;

	/**
 	* @param \Magento\Customer\Model\Session $customerSession
 	* @param \Magento\Framework\App\Http\Context $httpContext
 	*/
	public function __construct(
    	\Magento\Customer\Model\Session $customerSession,
    	\Magento\Framework\App\Http\Context $httpContext,
		\Psr\Log\LoggerInterface $logger
	) {
    	$this->customerSession = $customerSession;
    	$this->httpContext = $httpContext;
		$this->logger=$logger;
	}

	/**
 	* @param \Magento\Framework\App\ActionInterface $subject
 	* @param callable $proceed
 	* @param \Magento\Framework\App\RequestInterface $request
 	* @return mixed
 	*/
	public function aroundDispatch(
    	\Magento\Framework\App\ActionInterface $subject,
    	\Closure $proceed,
    	\Magento\Framework\App\RequestInterface $request
	) {
    	$this->httpContext->setValue(
        	'register_as_a',
        	$this->customerSession->getCustomer()->getData('register_as_a'),
        	false
    	);
		$this->logger->debug($this->customerSession->getCustomer()->getData('register_as_a'));
    	return $proceed($request);
	}
}