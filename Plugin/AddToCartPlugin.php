<?php
namespace Matvey\Input\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Controller\Cart\Add;

/**
 * Class AccountManagementPlugin
 *
 * @category  Colgee
 * @package   Colgee_Sample
 */
class AddToCartPlugin
{
    protected $productRepository;
    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function beforeExecute(Add $subject)
    {

        $sku = $subject->getRequest()->getParam('skuProducts',false);
        //TODO:: type: "Magento\Framework\Exception\NoSuchEntityException"
        $product = $this->productRepository->get($sku);
        $productId = $product->getId();
        $subject->getRequest()->setParam('product', $productId);

        return [];
    }
}