<?php

namespace Matvey\Input\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Mtf\Config\FileResolver\ScopeConfig;

/**
 * Class Router
 */
class Router implements RouterInterface
{
    const XML_PATH_INPUT = 'input/';
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request) {
        $identifier = trim($request->getPathInfo(), '/');

        $url = $this->scopeConfig->getValue('input/general/display_text');

        $re = '/'.$url.'\.(html|htm|[a-zA-Z]\w{1,3})$/m';
        $redirect = preg_match($re, $identifier);

        if ($redirect) {
            $request->setModuleName('matvey');
            $request->setControllerName('index');
            $request->setActionName('index');

            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        return null;
    }
}
