<?php
namespace Darsh\Callforprice\Controller\Form;

use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Submit
 * @package Darsh\Callforprice\Controller\Form
 */
class Submit extends \Magento\Framework\App\Action\Action
{

    const XML_PATH_EMAIL_SENDER = 'trans_email/ident_general/email';
    const XML_PATH_EMAIL_SEND_TO = 'callforprice/call_for_price/send_email_to';
    protected $_storeManager;
    protected $scopeConfig;
    protected $_transportBuilder;
    protected $inlineTranslation;

  
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
    )
    {
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        parent::__construct($context);
    }

    public function execute()
    {        
        $data = $this->getRequest()->getParams();
        $postObject = new \Magento\Framework\DataObject();
        $post = $this->getRequest()->getParams();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultarray = array();
        if ($data) {             
            $model = $this->_objectManager->create('Darsh\Callforprice\Model\Callforprice');
            $model->setData($data);             
            try {
                $model->save();
                /* email code for admin */
                $customerName = $post['customer_name'];
                $customerEmail = $post['customer_email'];
                $customerTelephone = $post['customer_telephone'];
                $requestDetail = $post['request_detail'];
                $productName = $post['product_name'];                
                $admin = $this->scopeConfig->getValue(self::XML_PATH_EMAIL_SEND_TO, ScopeInterface::SCOPE_STORE);
                $dataAdmin = [
                    'customer_name' => $customerName,
                    'customer_email' => $customerEmail,
                    'customer_telephone' => $customerTelephone,
                    'request_detail' => $requestDetail,
                    'product_name' => $productName
                ];
                $this->sendAdminEmail($postObject, $dataAdmin, $admin);                
                /* email code for admin end */
                /* email code for customer */
                $dataCustomer = [
                    'customer_name' => $customerName
                ];
                $this->sendCustomerEmail($postObject, $dataCustomer, $customerEmail);
                /* email code for customer */
                $resultarray['status'] = "success";
                $resultarray['message'] = "Your request has been received we will contact you.";
            } catch (\Exception $e) {                
                echo $e->getMessage();
                $resultarray['status'] = "error";
                $resultarray['message'] = "Something went wrong while saving the community.";
            }
        }
        $resultJson->setData($resultarray);
        return $resultJson;
    }

    protected function sendAdminEmail($postObject, $dataAdmin, $admin)
    {
        $postObject->setData($dataAdmin);
        $transportAdmin = $this->_transportBuilder
            ->setTemplateVars(['data' => $postObject])
            ->setTemplateIdentifier('callforprice_call_for_price_email_template_admin')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID
                ]
            )
            ->setFrom(['email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, ScopeInterface::SCOPE_STORE),
                'name' => $this->scopeConfig->getValue('trans_email/ident_general/email', ScopeInterface::SCOPE_STORE)])
            ->addTo($admin)
            ->getTransport();
        $transportAdmin->sendMessage();
        /* email code admin */
        $this->inlineTranslation->resume();
    }
   
    protected function sendCustomerEmail($postObject, $dataCustomer, $email)
    {

        $postObject->setData($dataCustomer);
        $transport = $this->_transportBuilder
            ->setTemplateVars(['data' => $postObject])
            ->setTemplateIdentifier('callforprice_call_for_price_email_template_customer')
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
