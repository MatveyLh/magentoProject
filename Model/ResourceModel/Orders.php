<?php

namespace Matvey\Input\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Orders extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('input_orders','order_id');
    }
}
