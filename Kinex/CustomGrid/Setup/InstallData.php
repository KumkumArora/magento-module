<?php

namespace Kinex\CustomGrid\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $date;
 
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->date = $date;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $dataNewsRows = [
            [
                'title' => 'Grids Table 1',
                'description' => 'Here is write grid description 1',
                'status' => 1,
                'updated_at' => $this->date->date(),
                'created_at' => $this->date->date()
            ],
            [
                'title' => 'Grids Table 2',
                'description' => 'Here is write grid description 2',
                'status' => 1,
                'updated_at' => $this->date->date(),
                'created_at' => $this->date->date()
            ]
        ];
        
        foreach($dataNewsRows as $data) {
            $setup->getConnection()->insert($setup->getTable('kinex_customgrid'), $data);
        }
    }
}
?>