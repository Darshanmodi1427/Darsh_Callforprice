<?php
namespace Darsh\Callforprice\Controller\Adminhtml\Callforprice;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Save
 * @package Darsh\Callforprice\Controller\Adminhtml\Callforprice
 */
class Save extends \Magento\Backend\App\Action
{

    /**
     *sender email value
     */
    const XML_PATH_EMAIL_SENDER = 'trans_email/ident_general/email';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
                                \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
                                \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Darsh\Callforprice\Model\Callforprice');

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
                $model->setCreatedAt(date('Y-m-d H:i:s'));
            }


            $model->setData($data);
            $status = $model->getData('status');
            $email = $model->getData('customer_email');
            $name = $model->getData('customer_name');
            $emailSent = $model->getData('email_sent');
            $postObject = new \Magento\Framework\DataObject();
            try {
                /*email code for status change*/
                if($status==2 && $emailSent==0)
                {
                    $dataCustomer = ['customer_name' => $name];
                    $this->sendCustomerEmail($postObject,$dataCustomer,$email);
                    $model->setData('email_sent','1');
                }
                /*email code for status change end*/
                $model->save();
                $this->messageManager->addSuccess(__('The Callforprice has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Callforprice.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $postObject
     * @param $dataCustomer
     * @param $email
     */
    protected function sendCustomerEmail($postObject, $dataCustomer, $email)
    {

        $postObject->setData($dataCustomer);
        $transport = $this->_transportBuilder
            ->setTemplateVars(['data' => $postObject])
            ->setTemplateIdentifier('callforprice_call_for_price_email_template_status')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID
                ]
            )
            ->setFrom(['email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, ScopeInterface::SCOPE_STORE),
                'name' => $this->scopeConfig->getValue('trans_email/ident_general/email', ScopeInterface::SCOPE_STORE)])
            ->addTo($email)
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

}