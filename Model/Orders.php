<?php

namespace Matvey\Input\Model;

use Magento\Framework\Model\AbstractModel;

class Orders extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Orders::class);
        parent::_construct();
    }
}
