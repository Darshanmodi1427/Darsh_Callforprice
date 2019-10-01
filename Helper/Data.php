<?php
namespace Darsh\Callforprice\Helper;

/**
 * Class Data
 * @package Darsh\Callforprice\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $sessionFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $catalogCategoryFactory;

    /**
     * @var \Magento\Catalog\Model\StoreManager
     */
    protected $storeManager;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Model\CategoryFactory $catalogCategoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\SessionFactory $sessionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $catalogCategoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->sessionFactory = $sessionFactory;
        $this->registry = $registry;
        $this->catalogCategoryFactory = $catalogCategoryFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     */
    public function submitformurl()
    {
        $submitformurl = $this->storeManager->getStore()->getBaseUrl() . 'callprice/form/submit';
        return $submitformurl;
    }

     public function isEnable()
    {
        return $this->scopeConfig->getValue('callforprice/call_for_price/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getButtonTitle()
    {
        $buttenTitle = $this->scopeConfig->getValue('callforprice/call_for_price/call_for_price_button_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($buttenTitle)
        {
            return $buttenTitle;
        }
        else
        {
            return "Call For Price";
        }
    }

    /**
     * @return mixed
     *check which customer group for which we will show call for price button
     */
    public function allowedCustomerGroup()
    {

        return $this->scopeConfig->getValue('callforprice/call_for_price/customer_groups', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getCurrentCustomerData()
    {
        $sessionData = $this->sessionFactory->create();
        if ($sessionData->isLoggedIn()) {
            return $sessionData->getCustomer();
        } else {
            return '';
        }
    }

    /**
     * @return mixed
     */
    public function getCurrentCustomerGroup()
    {
        $groupId = $this->customerSession->getCustomerGroupId(); //Get Customers Group ID
        return $groupId;

    }

    /**
     * @return mixed
     */
    public function getSpecificDateRange()
    {
        return $this->scopeConfig->getValue('callforprice/call_for_price/specific_date_range', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getFromDate()
    {
        return $this->scopeConfig->getValue('callforprice/call_for_price/from_date', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getToDate()
    {
        return $this->scopeConfig->getValue('callforprice/call_for_price/to_date', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     * Get From To date
     */
    public function getDateToShowButton()
    {
        if ($this->getSpecificDateRange() == 1) {
            $fromDate = date('m/d/Y', strtotime($this->getFromDate()));
            $toDate = date('m/d/Y', strtotime($this->getToDate()));
            $todayDate = date('m/d/Y');
            if (strtotime($todayDate) >= strtotime($fromDate) && strtotime($todayDate) <= strtotime($toDate)) {
                return 1;
            }
        }
    }

    /**
     * @param $_product
     * @return int
     */
    public function getAllData($_product)
    {        
        $callpriceflag = 0;
        $callpriceflagparent = 0;
        $callforprice = 0;
        $showCallForPriceButton= 0;
        /*code for category product and date*/
        $buttonDate = $this->getDateToShowButton();

        if($buttonDate==1)
        {
            $showCallForPriceButton =1;
            return $showCallForPriceButton;
        }

        $currentCategory = $this->registry->registry('current_category'); // check for current category
        if ($currentCategory) {            
            $cat = $this->catalogCategoryFactory->create()->load($currentCategory->getId());
            $callpriceflag = $cat->getCallForPrice();
            if ($cat->getParentCategory()) {                
                $callpriceflagparent = $cat->getParentCategory()->getCallForPrice();
            }
        }
        // Check for product
        $callforprice = 0; 
        $categories = $_product->getCategoryIds();
        $callforpriceCategory = array();
        $callforpriceParent = array();
            foreach($categories as $category){
                $productcategory = $this->catalogCategoryFactory->create()->load($category);
                if ($productcategory->getParentCategory()) {
                    
                    $callforpriceParent[] = $productcategory->getParentCategory()->getCallForPrice();
                }
                $callforpriceCategory[] = $productcategory->getCallForPrice();
                $callforprice = $_product->getCallForPrice();
            
            }
            if(in_array('1',$callforpriceCategory))
            {                
                $callforprice = 1;
            }
            if(in_array('1',$callforpriceParent))
            {             
                $callforprice = 1;
            }
             
        if ($callforprice == 1 || $callpriceflagparent == 1 || $callpriceflag == 1) {            
           return $showCallForPriceButton = 1;
        }
        else{            
            return $showCallForPriceButton = 0;
        }
        
        /*code for category product and date end*/
    }

    /**
     * @param $_product
     * @return int
     */
    public function showCallForPriceButton($_product)
    {        
        $showCallForPriceButton= 0;

        $allowed_customer_groups = array();
        $customer_groups = $this->allowedCustomerGroup();
        if ($customer_groups != "") {     
            $allowed_customer_groups = explode(',', $customer_groups);
        }

        $c_group = $this->getCurrentCustomerGroup();        
        if($c_group!=0)
        {
            if (count($allowed_customer_groups) > 0) {
                if (in_array($c_group, $allowed_customer_groups)) {                    
                    return $this->getAllData($_product);
                }
                else{
                    return $showCallForPriceButton;
                }
            }
            else
            {
                return $this->getAllData($_product);
            }
        }
        else{
            return $this->getAllData($_product);
        }
    }
}