<?php
namespace Darsh\Callforprice\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
 
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}

