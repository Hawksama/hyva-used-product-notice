<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\UsedProductNotice\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Hyva\Theme\ViewModel\CurrentProduct;
use Psr\Log\LoggerInterface;
use Hawksama\UsedProductNotice\Model\Config;

class UsedProduct implements ArgumentInterface
{
    public function __construct(
        private readonly BlockRepositoryInterface $blockRepository,
        private readonly LoggerInterface $logger,
        private readonly CurrentProduct $currentProductViewModel,
        private readonly Config $config
    ) {
    }

    /**
     * Check if the product has the 'UsedProduct' attribute set to "Yes"
     */
    public function shouldShowBlock(): bool
    {
        if($this->config->isEnabledOnProductPage()) {
            $product = $this->getCurrentProduct();
            $attribute = $product->getCustomAttribute('used_product');
            return $attribute !== null && (bool) $attribute->getValue();
        }

        return false;
    }

    /**
     * Get CMS Block content
     */
    public function getCmsBlockContent(): ?string
    {
        try {
            $block = $this->blockRepository->getById('used_product_message');
            return $block->getContent();
        } catch (NoSuchEntityException $e) {
            $this->logger->error("Block 'used_product_message' not found: " . $e->getMessage());
            return '';
        }
    }

    /**
     * Get the current product using the injected Hyvä ViewModel for the current product
     */
    private function getCurrentProduct(): ProductInterface
    {
        return $this->currentProductViewModel->get();
    }
}
