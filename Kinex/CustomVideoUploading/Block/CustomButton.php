<?php

namespace Kinex\CustomVideoUploading\Block;

use Magento\Framework\View\Element\Template;

class CustomButton extends Template
{
    protected $registry;

    protected $_productRepository;

    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {

        $this->_productRepository = $productRepository;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getProductId()
    {
        // Retrieve the selected product's ID from the registry
        return $this->registry->registry('current_product')->getId();
    }

    public function getProductData($productId)
    {
        try {
            return $this->_productRepository->getById($productId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
