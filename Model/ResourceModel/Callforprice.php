<?php
namespace Darsh\Callforprice\Model\ResourceModel;


/**
 * Class Callforprice
 * @package Darsh\Callforprice\Model\ResourceModel
 */
class Callforprice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     *get call for price data by id
     */
    protected function _construct()
    {
        $this->_init('darsh_callprice_request', "id");
    }
}