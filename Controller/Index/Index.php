<?php

namespace Matvey\Input\Controller\Index;

use Magento\Framework\Data\Form\FormKey;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{

    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page|null
     */
    public function execute() {

        if($this->getRequest()->isXmlHttpRequest()) {
            $this->getResponse()->setStatusHeader(403, '1.1', 'Forbidden');

            return null;
        }

        return $this->pageFactory->create();
    }
}
