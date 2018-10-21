<?php
namespace Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab\Renderer;

/**
 * Class Statusname
 * @package Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab\Renderer
 */
class Statusname extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Statusname constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Context $context, $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $status = 'New';
        if($row->getStatus() == 2){
            $status = 'Completed';
        }
        return $status;
    }
}
