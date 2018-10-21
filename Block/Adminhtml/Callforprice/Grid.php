<?php

namespace Darsh\Callforprice\Block\Adminhtml\Callforprice;

/**
 * Class Grid
 * @package Darsh\Callforprice\Block\Adminhtml\Callforprice
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Darsh\Callforprice\Model\callforpriceFactory
     */
    protected $_callforpriceFactory;

    /**
     * @var \Darsh\Callforprice\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Darsh\Callforprice\Model\callforpriceFactory $callforpriceFactory
     * @param \Darsh\Callforprice\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Darsh\Callforprice\Model\CallforpriceFactory $CallforpriceFactory,
        \Darsh\Callforprice\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    )
    {
        $this->_callforpriceFactory = $CallforpriceFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('callforprice/*/index', ['_current' => true]);
    }

    /**
     * @param \Darsh\Callforprice\Model\callforprice|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {

        return $this->getUrl(
            'callforprice/*/edit',
            ['id' => $row->getId()]
        );

    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_callforpriceFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


        $this->addColumn(
            'customer_name',
            [
                'header' => __('Name'),
                'index' => 'customer_name',
            ]
        );

        $this->addColumn(
            'customer_email',
            [
                'header' => __('Email'),
                'index' => 'customer_email',
            ]
        );

        $this->addColumn(
            'customer_telephone', [
                'header' => __('Telephone'),
                'index' => 'customer_telephone',
            ]
        );

        $this->addColumn(
            'product_id', [
                'header' => __('Product Id'),
                'index' => 'product_id',
            ]
        );

        $this->addColumn(
            'product_name', [
                'header' => __('Product Name'),
                'index' => 'product_name',
            ]
        );

        $this->addColumn(
            'status', [
                'header' => __('Status'),
                'index' => 'status',
                'renderer' => 'Darsh\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab\Renderer\Statusname'
            ]
        );

        $this->addColumn(
            'edit', [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit'
                        ],
                        'field' => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );


        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id');
        //$this->getMassactionBlock()->setTemplate('Darsh_Callforprice::callforprice/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('callforprice');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('callforprice/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('callforprice/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }


}