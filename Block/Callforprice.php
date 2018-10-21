<?php
namespace Darsh\Callforprice\Block;


/**
 * Class Callforprice
 * @package Darsh\Callforprice\Block
 */
class Callforprice extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    /**
     * Wrap with standard required container
     *
     * @param string $html
     * @return string
     */
    public function wrapResult($html)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeConfig = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface');
        $callPriceHelper = $objectManager->get('Darsh\Callforprice\Helper\Data');
        $callForPrice = $callPriceHelper->showCallForPriceButton($this->getSaleableItem());
        if($callForPrice==0):
            return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
                'data-role="priceBox" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $html . '</div>';
        else :
            return '<div class="price-box call-for-price"><a href="javascript:void(0);"></span></div>';
        endif;

    }

}
