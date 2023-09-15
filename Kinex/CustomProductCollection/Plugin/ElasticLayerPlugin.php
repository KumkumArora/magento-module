<?php

namespace Kinex\CustomProductCollection\Plugin;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Kinex\CustomProductCollection\Block\CustomData;

 class ElasticLayerPlugin
 {
//    protected $helperObj;    
   protected $productCollectionFactory;
   protected $customData;
   protected $request;

   public function __construct(
      CollectionFactory $productCollectionFactory,
      \Magento\Framework\App\Request\Http $request,
      CustomData $customData
   ) 
   {
      $this->productCollectionFactory = $productCollectionFactory;
      $this->customData = $customData;
      $this->request = $request;
   }

   public function beforeQuery($subject,$query) 
   {
      $loggedIn = $this->customData->getCustomerIsLoggedIn();
      if($loggedIn){
         $customAttribute = $this->customData->getCustomerAttribute();
      }

      $filteredIds = $this->productCollectionFactory->create()
                     ->addAttributeToSelect('*');
      $filteredIds->addAttributeToFilter([
                  ['attribute' => 'product_for', ['eq' => $customAttribute]]]);

      if($this->request->getFullActionName()=='catalog_category_view') {    
         $filteredIds->addAttributeToFilter('product_for', ['eq' => $customAttribute]);
      }

      $filteredIds = $filteredIds->getAllIds();

      if(!$filteredIds || count($filteredIds) < 1)  {

         return [$query];
      }

      // Add the entity_id filter to the Elastic collection
      $query['body']['query']['bool']['filter'] = ['ids' => [ 'values' => $filteredIds]];

      return [$query];
   }
}