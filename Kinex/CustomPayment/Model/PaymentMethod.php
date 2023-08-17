<?php

namespace Kinex\CustomPayment\Model;

/**
 * Pay In Store payment method model
 */
class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
     /**
     * Payment code
     *
     * @var string
     */
     protected $_code = 'custompayment';
}