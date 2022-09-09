<?php

namespace Ubermanu\PricePerWeight\Pricing\Render;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Pricing\Render\AbstractAdjustment;
use Magento\Framework\View\Element\Template\Context;
use Ubermanu\PricePerWeight\Helper\Config as ConfigHelper;

class Adjustment extends AbstractAdjustment
{
    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    public function __construct(
        Context $context,
        PriceCurrencyInterface $priceCurrency,
        ConfigHelper $configHelper,
        ProductRepositoryInterface $productRepository,
        PriceHelper $priceHelper,
        array $data = []
    ) {
        $this->configHelper = $configHelper;
        $this->productRepository = $productRepository;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $priceCurrency, $data);
    }

    /**
     * @inheritDoc
     */
    protected function apply()
    {
        if ($this->getData('price_type_code') == 'tier_price') {
            return '';
        }

        return $this->toHtml();
    }

    /**
     * @inheritDoc
     */
    public function getAdjustmentCode()
    {
        return \Ubermanu\PricePerWeight\Pricing\Adjustment::ADJUSTMENT_CODE;
    }

    /**
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getProduct()
    {
        return $this->productRepository->getById($this->getSaleableItem()->getId());
    }

    /**
     * @return bool
     * @throws LocalizedException
     */
    public function isFrontend(): bool
    {
        return $this->_appState->getAreaCode() == Area::AREA_FRONTEND;
    }

    /**
     * Returns TRUE if the product has weight.
     *
     * @param ProductInterface $product
     * @return bool
     */
    public function productHasWeight(ProductInterface $product): bool
    {
        return $product->getWeight() > 0;
    }

    /**
     * Get the price per weight, formatted.
     *
     * @param ProductInterface $product
     * @return string
     */
    public function getPricePerWeight(ProductInterface $product)
    {
        $price = $product->getPrice();
        $weight = $product->getWeight();

        if ($weight == 0) {
            return '';
        }

        return $this->priceHelper->currency($price / $weight, true, false);
    }

    /**
     * Returns the weight unit (as single).
     *
     * @return string
     */
    public function getWeightUnit()
    {
        return \preg_replace('/s$/', '', $this->configHelper->getWeightUnit());
    }

    /**
     * Disable cache for this price adjustment.
     *
     * @return null
     */
    public function getCacheLifetime()
    {
        return null;
    }
}
