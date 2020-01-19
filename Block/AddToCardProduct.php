<?php

namespace Matvey\Input\Block;

use Magento\Framework\Controller\Result\JsonFactory;
use Composer\Config;
use Matvey\Input\Model\ConfigProvider;
use Magento\Framework\Json\Helper\Data;

class AddToCardProduct extends \Magento\Framework\View\Element\Template
{

    protected $resultJsonFactory;

    protected $configs;

    protected $jsonHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ConfigProvider $configs,
        JsonFactory $resultJsonFactory,
        Data $jsonHelper,
        array $data = []
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->configs = $configs;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context, $data);
    }


    public function getSelectorForm()
    {
        $formId = $this->configs->getFormId();

        return $formId;
    }

    public function getInputName()
    {
        $nameInput = $this->configs->getNameInput();

        return $nameInput;
    }

    public function getFormWidgetJSONConfig()
    {
        $formIdJSON = $this->configs->getFormId();
        $nameInputJSON = $this->configs->getNameInput();
        $dataJSON = [$formIdJSON,$nameInputJSON];

        return $this->jsonHelper->jsonEncode($dataJSON);
    }
}
