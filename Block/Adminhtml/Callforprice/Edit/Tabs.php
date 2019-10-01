<?php
namespace Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{

    protected function _construct()
    {
        parent::_construct();
        $this->setId('callforprice_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Callforprice Information'));
    }
}