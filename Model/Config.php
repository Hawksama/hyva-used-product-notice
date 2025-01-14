<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\HyvaUsedProductNotice\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const USED_PRODUCT_ENABLED = 'used_product/main/enable';
    public const ENABLED_ON_PRODUCT_PAGE = 'used_product/main/enable_on_product_page';

    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::USED_PRODUCT_ENABLED,
            ScopeInterface::SCOPE_STORES
        );
    }

    public function isEnabledOnProductPage(): bool
    {
        return $this->isEnabled() && $this->scopeConfig->isSetFlag(
            self::ENABLED_ON_PRODUCT_PAGE,
            ScopeInterface::SCOPE_STORES
        );
    }
}
