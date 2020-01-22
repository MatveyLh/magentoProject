<?php

namespace Matvey\Input\Controller\Cart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;

class Add extends Action
{

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var FormKey
     */
    private $formKey;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager,
        FormKey $formKey,
        Cart $cart,
        ProductRepositoryInterface $productRepository,
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->storeManager = $storeManager;
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }


    public function execute()
    {
        try {
            $sku = $this->getRequest()->getParam('skuProducts', false);
            // TODO:: проверку на налл
            if ($sku === null) {
                $this->messageManager->addErrorMessage("Invalid SKU");
            }
            else {
                $arrSkuProducts = explode(',', $sku);
                for ($i = 0; $i < count($arrSkuProducts); $i++){
                    $sku = $arrSkuProducts[$i];
                    $product = $this->initProduct($sku);
                    if ($this->validateProduct($product)) {
                        $this->addToCard($product);
                        $this->messageManager->addSuccessMessage(__('Product already add to card'));
                    }
                    else {
                        $this->messageManager->addErrorMessage(__('Please, enter the SKU only for Simple product'));
                        $this->messageManager->addErrorMessage(__("SKU is not valid"));
                        continue;
                    }
                }
            }
        }
        catch(\Magento\Framework\Exception\LocalizedException $exception) {
            $this->messageManager->addErrorMessage(__("Unknown product"));

            return $this->goBack();
        }

        return $this->goBack();
    }

    /**
     * @param $sku
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function initProduct($sku)
    {

        return $this->productRepository->get($sku);
    }

    /**
     * @param $product
     * @return bool
     */
    protected function validateProduct($product)
    {

        return ($product && $product->getTypeId() === 'simple');
    }

    /**
     * @param $product
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function addToCard($product)
    {
        $productId = $product->getId();
        $params = array(
            'form_key' => $this->formKey->getFormKey(),
            'product' => $productId,
            'qty' => 1
        );

        $this->cart->addProduct($productId, $params);
        $this->cart->save();
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function goBack()
    {
        if(!$this->getRequest()->isAjax()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
    }
}
