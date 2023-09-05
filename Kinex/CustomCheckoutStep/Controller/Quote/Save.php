<?php

namespace Kinex\CustomCheckoutStep\Controller\Quote;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $quoteIdMaskFactory;

    protected $quoteRepository;

    protected $_logger;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Kinex\CustomCheckoutStep\Block\Session $block,
        array $data = []
    ) {
        $this->_logger = $logger; 
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->block = $block;
        parent::__construct($context,$data);

    }

    /**
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    { 
        $post = $this->getRequest()->getPostValue();
        $msg = $this->getRequest()->getPostValue('text_field');
        if ($post) {
            $cartId        = $post['cartId'];
            $textField     = $post['text_field'];
            $selectField   = $post['select_field'];
            $dateField     = $post['date_field'];
            $checkoutField = $post['checkbox_field'];
            $loggin        = $post['is_customer'];
           
            if ($loggin === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('text_field', $textField);
            $quote->setData('select_field', $selectField);
            $quote->setData('date_field', $dateField);
            $quote->setData('checkbox_field', $checkoutField);

            $this->quoteRepository->save($quote);
        }

	}
}
?>