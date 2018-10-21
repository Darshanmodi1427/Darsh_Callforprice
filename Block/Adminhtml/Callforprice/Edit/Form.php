<?php

namespace Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit;


/**
 * Class Form
 * @package Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @return mixed
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}