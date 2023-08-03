<?php
namespace Kinex\CustomGrid\Block\Adminhtml;

class Allgrids extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_allgrids';
        $this->_blockGroup = 'Kinex_CustomGrid';
        $this->_headerText = __('Manage Grids');

        parent::_construct();

        if ($this->_isAllowedAction('Kinex_CustomGrid::save')) {
            $this->buttonList->update('add', 'label', __('Add Grids'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
?>