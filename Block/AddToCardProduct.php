<?php

namespace Matvey\Input\Block;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Matvey\Input\Model\ConfigProvider;

class AddToCardProduct extends Template
{

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ConfigProvider
     */
    protected $configs;

    /**
     * @var
     */
    protected $jsonHelper;

    /**
     * @var
     */
    protected $formKey;

    public function __construct(
        Context $context,
        ConfigProvider $configs,
        JsonFactory $resultJsonFactory,

        array $data = []
    ) {

        $this->configs = $configs;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context, $data);
        // TODO:: add code
    }


    /**
     * @return mixed
     */
    public function getSelectorForm()
    {

        return $this->configs->getFormId();
    }

    /**
     * @return mixed
     */
    public function getInputName()
    {

        return $this->configs->getNameInput();
    }

    /**
     * @return mixed
     */
    public function getFormKey()
    {

        return $this->formKey->getFormKey();
    }
}
