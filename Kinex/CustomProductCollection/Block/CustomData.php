<?php

namespace Kinex\CustomProductCollection\Block;

class CustomData extends \Magento\Framework\View\Element\Template
{
	protected $httpContext;

	public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Framework\App\Http\Context $httpContext,
    	array $data = []
	) {
    	$this->httpContext = $httpContext;
    	parent::__construct($context, $data);
	}

	public function getCustomerIsLoggedIn()
	{
    	return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
	}

	public function getCustomerAttribute()
	{
    	return $this->httpContext->getValue('register_as_a');
	}
}