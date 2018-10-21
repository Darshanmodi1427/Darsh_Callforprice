<?php
namespace Darsh\Callforprice\Controller\Adminhtml\Index;

/**
 * Class Index
 * @package Darsh\Callforprice\Controller\Adminhtml\Index
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     *call for price index
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}

