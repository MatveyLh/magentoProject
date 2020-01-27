<?php

namespace Matvey\Input\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class ConfigProvider extends AbstractModel
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ConfigProvider constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct(
            $context,
            $registry
        );
    }

    /**
     * @return mixed
     */
    public function getFormId ()
    {
        return $this->scopeConfig->getValue('input/frontend/set_id_form');
    }

    /**
     * @return mixed
     */
    public function getNameInput ()
    {
        return $this->scopeConfig->getValue('input/frontend/selector_input_name');
    }
}
