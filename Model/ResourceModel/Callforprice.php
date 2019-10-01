<?php
namespace Darsh\Callforprice\Model\ResourceModel;

class Callforprice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected function _construct()
    {
        $this->_init('darsh_callprice', "id");
    }
}