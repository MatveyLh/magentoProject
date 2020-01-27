<?php


namespace Matvey\Input\Controller\ManageOrders;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Matvey\Input\Model\OrdersFactory;

class Index extends Action
{

    /**
     * @var OrdersFactory
     */
    protected $manage;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
        Context $context,
        OrdersFactory $manage,
        ProductRepositoryInterface $productRepository
    ) {
        $this->manage = $manage;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }
    public function execute()
    {
        $sku = $this->getRequest()->getParam('skuProducts',false);
        $product = $this->productRepository->get($sku);
        $productName = $product->getName();
        $data = array('name'=>$productName);
        $manage = $this->manage->create();
        $manage->setData($data);
        if($manage->save()){
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('matvey');
        return $resultRedirect;
    }
}


