<?php
namespace Darsh\Callforprice\Model;

/**
 * Class Callforprice
 * @package Darsh\Callforprice\Model
 */
class Callforprice extends \Magento\Framework\Model\AbstractModel {

    /**
     * Callforprice constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     *call callforprice resource model
     */
    protected function _construct() {
        $this->_init('Darsh\Callforprice\Model\ResourceModel\Callforprice');
    }
}