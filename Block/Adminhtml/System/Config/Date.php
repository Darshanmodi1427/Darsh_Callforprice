<?php

namespace Darsh\Callforprice\Block\Adminhtml\System\Config;

/**
 * Class Date
 * @package Darsh\Callforprice\Block\Adminhtml\System\Config
 */
class Date extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return mixed
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->setDateFormat(\Magento\Framework\Stdlib\DateTime::DATE_INTERNAL_FORMAT);
        $element->setTimeFormat(null);
        return parent::render($element);
    }
}