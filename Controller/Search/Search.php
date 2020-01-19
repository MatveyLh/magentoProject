<?php

namespace Matvey\Input\Controller\Search;

use Magento\Framework\App\Action\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;


class Search extends Action
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        JsonFactory $resultJsonFactory,
        PageFactory $pageFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        if ($this->getRequest()->isAjax())
        {
            $quest = $this->getRequest()->getPost('value');
            $collection = $this->collectionFactory->create();
            $collection->addAttributeToSelect('*');
            $collection->addFieldToFilter('sku', ['like' => '%'.$quest.'%']);

            $resultSearch = [];
            foreach ($collection as $product) {
                array_push($resultSearch,$product->getData());
            }
            $result->setData($resultSearch);
        }
        return $result;
    }
}
