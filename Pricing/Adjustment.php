<?php

namespace Ubermanu\PricePerWeight\Pricing;

use Magento\Framework\Pricing\Adjustment\AdjustmentInterface;
use Magento\Framework\Pricing\SaleableInterface;

class Adjustment implements AdjustmentInterface
{
    /**
     * @var null
     */
    protected $sortOrder;

    /**
     * Adjustment code
     */
    const ADJUSTMENT_CODE = 'price_per_weight';

    public function __construct($sortOrder = null)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @inheritDoc
     */
    public function getAdjustmentCode()
    {
        return self::ADJUSTMENT_CODE;
    }

    /**
     * @inheritDoc
     */
    public function isIncludedInBasePrice()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isIncludedInDisplayPrice()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function extractAdjustment($amount, SaleableInterface $saleableItem, $context = [])
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function applyAdjustment($amount, SaleableInterface $saleableItem, $context = [])
    {
        return $amount;
    }

    /**
     * @inheritDoc
     */
    public function isExcludedWith($adjustmentCode)
    {
        return $this->getAdjustmentCode() === $adjustmentCode;
    }

    /**
     * @inheritDoc
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
}
