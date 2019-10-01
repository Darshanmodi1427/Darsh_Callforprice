<?php

namespace Darsh\Callforprice\Model\ResourceModel\Callforprice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init('Darsh\Callforprice\Model\Callforprice', 'Darsh\Callforprice\Model\ResourceModel\Callforprice');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>