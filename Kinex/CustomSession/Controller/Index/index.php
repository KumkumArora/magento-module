<?php 
namespace Kinex\CustomSession\Controller\Index;

class index extends \Magento\Framework\App\Action\Action
{  
    private $session;

    private $customerSession;
    
    private $pageFactory;

    private $catalogSession;

    public function __construct(
      \Kinex\CustomSession\Block\Session $session,
      \Magento\Framework\App\Action\Context $context,
      \Magento\Customer\Model\Session $customerSession,
      \Magento\Catalog\Model\Session $catalogSession,
      \Magento\Framework\View\Result\PageFactory $pageFactory,
      array $data = []
    ) {

      $this->pageFactory = $pageFactory;
      $this->session = $session;
      $this->catalogSession = $catalogSession;
      $this->customerSession = $customerSession;
      parent::__construct($context,$data);
    }


    public function execute() {
      
          
        $customer = $this->customerSession->getCustomer();
        //dd($customer);

        $catalog = $this->catalogSession;
        // dd($catalog);

        // $this->_view->loadLayout();
        // $this->_view->renderLayout();
        // Set Custom Session 
        $details = [
            'name' => "Kumkum Arora",
            'email' => "kumkum.infino@gmail.com",
        ];
        $this->session->setCustomSession($details);


        // Get Custom Session
        $this->session->getCustomerSession();

        // unset custom session
        // $this->session->unsCustomSession();

        // To get all session data : 
        $this->session->getData();

        return $this->pageFactory->create();

    }
}