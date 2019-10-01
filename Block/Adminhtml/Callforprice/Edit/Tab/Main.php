<?php

namespace Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

   
    protected $_systemStore;
    protected $_status;


    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Darsh\Callforprice\Model\Status $status,
        array $data = []
    )
    {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('callforprice');
        $isElementDisabled = false;
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }


        $fieldset->addField(
            'customer_name',
            'text',
            [
                'name' => 'customer_name',
                'label' => __('Name'),
                'title' => __('Name'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'customer_email',
            'text',
            [
                'name' => 'customer_email',
                'label' => __('Email'),
                'title' => __('Email'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'customer_telephone',
            'text',
            [
                'name' => 'customer_telephone',
                'label' => __('Telephone'),
                'title' => __('Telephone'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'product_name',
            'text',
            [
                'name' => 'product_name',
                'label' => __('Product Name'),
                'title' => __('Product Name'),
                'disabled' => $isElementDisabled
            ]
        );

         $fieldset->addField(
            'request_detail',
            'text',
            [
                'name' => 'request_detail',
                'label' => __('Request Details'),
                'title' => __('Request Details'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'title' => __('Status'),
                'options' => array('1' => 'New', '2' => 'Completed'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'email_sent', 'hidden',
            ['name' => 'email_sent']
        );


        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Item Information');
    }

    public function getTabTitle()
    {
        return __('Item Information');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getTargetOptionArray()
    {
        return array(
            '_self' => "Self",
            '_blank' => "New Page",
        );
    }
}
