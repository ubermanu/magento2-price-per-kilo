<?php

namespace Ubermanu\PricePerWeight\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Config extends AbstractHelper
{
    const XML_PATH_GENERAL_LOCALE_WEIGHT_UNIT = 'general/locale/weight_unit';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getWeightUnit(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_LOCALE_WEIGHT_UNIT);
    }
}
