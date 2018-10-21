<?php

namespace Darsh\Callforprice\Controller\Adminhtml\Callforprice;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Darsh\Callforprice\Controller\Adminhtml\Callforprice
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPagee;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Darsh_Callforprice::callforprice');
        $resultPage->addBreadcrumb(__('Darsh'), __('Darsh'));
        $resultPage->addBreadcrumb(__('Manage item'), __('Manage Callforprice'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Callforprice'));

        return $resultPage;
    }
}
?>