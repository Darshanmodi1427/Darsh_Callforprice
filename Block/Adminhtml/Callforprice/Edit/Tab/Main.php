<?php

namespace Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab;


/**
 * Class Main
 * @package Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Darsh\Callforprice\Model\Status
     */
    protected $_status;

    /**
     * Main constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Darsh\Callforprice\Model\Status $status
     * @param array $data
     */
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

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Darsh\Callforprice\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('callforprice');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
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

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Item Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * @return array
     */
    public function getTargetOptionArray()
    {
        return array(
            '_self' => "Self",
            '_blank' => "New Page",
        );
    }
}
