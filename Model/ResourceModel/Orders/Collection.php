<?php

namespace Matvey\Input\Model\ResourceModel\Orders;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $idFieldName = 'order_id';

    /**
     * @var string
     */
    protected $eventPrefix = 'input_orders_collection';

    /**
     * @var string
     */
    protected $eventObject = 'orders_collection';

    protected function _construct()
    {
        $this->_init(
            \Matvey\Input\Model\Orders::class,
            \Matvey\Input\Model\ResourceModel\Orders::class
        );
        $this->_setIdFieldName($this->idFieldName);
    }
}
