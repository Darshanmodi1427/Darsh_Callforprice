<?php

namespace Darsh\Callforprice\Block\Adminhtml\Callforprice;


class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
   
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('callforprice')->getId()) {
            return __("Edit Callforprice '%1'", $this->escapeHtml($this->_coreRegistry->registry('callforprice')->getTitle()));
        } else {
            return __('New Callforprice');
        }
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Darsh_Callforprice';
        $this->_controller = 'adminhtml_callforprice';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Callforprice'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );

        $this->buttonList->update('delete', 'label', __('Delete Callforprice'));
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('callforprice/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }

    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'content');
                }
            };
        ";
        return parent::_prepareLayout();
    }

}