<?php
 namespace Kinex\CustomGrid\Model\Allgrids; 

 use Kinex\CustomGrid\Model\ResourceModel\Allgrids\CollectionFactory; 
 use Magento\Framework\App\Request\DataPersistorInterface;

 /** 
  * Class DataProvider 
  */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider 
{ 
    /** 
     * @var \Kinex CustomGrid\Model\ResourceModel\Allgrids\Collection 
     */ 
    protected $collection;

    /** 
     * @var DataPersistorInterface 
     */ 
    protected $dataPersistor;

    /** 
     * @var array 
     */ 
    protected $loadedData; 

    protected $data; 

     /** 
      * @param string $name 
      * @param string $primaryFieldName 
      * @param string $requestFieldName 
      * @param CollectionFactory $allgridsCollectionFactory 
      * @param DataPersistorInterface $dataPersistor 
      * @param array $meta 
      * @param array $data 
      */     
    public function __construct( 
        $name, 
        $primaryFieldName,
        $requestFieldName, 
        CollectionFactory $allgridsCollectionFactory, 
        DataPersistorInterface $dataPersistor, 
        array $meta = [], 
        array $data = [] 
    ){ 
        $this->collection = $allgridsCollectionFactory->create(); $this->dataPersistor = $dataPersistor; 
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta); 
    }
        
    /** 
      * Prepares Meta 
      * 
      * @param array $meta 
      * @return array 
      */ 
    public function prepareMeta(array $meta)
    { 
        return $meta; 
    } 

    /** 
     * Get data * 
     * @return array 
     */ 
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /* @var $tabledata \Kinex\CustomGrid\Model\Allgrids */
        foreach($items as $tabledata)
        {
            $this->loadedData[$tabledata->getId()] = $tabledata->getData();
        }
        $data = $this->dataPersistor->get('kinex_customgrid');
        if(!empty($data))
        {
            $tabledata = $this->collection->getNewEmptyItem();
            $tabledata->setData($data);
            $this->loadedData[$tabledata->getId()]=$tabledata->getData();
            $this->dataPersistor->clear('kinex_customgrid');
        }
        return $this->loadedData;
    }

        
}
    