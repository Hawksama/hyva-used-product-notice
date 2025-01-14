<?php

declare(strict_types=1);

/**
 * Copyright © Your Name
 * See COPYING.txt for license details.
 */

namespace Hawksama\HyvaUsedProductNotice\Test\Integration;

use Magento\TestFramework\TestCase\AbstractController;
use TddWizard\Fixtures\Catalog\ProductBuilder;
use TddWizard\Fixtures\Catalog\ProductFixture;
use TddWizard\Fixtures\Catalog\ProductFixtureRollback;

class UsedProductPageTest extends AbstractController
{
    /**
     * @var ProductFixture
     */
    private static ProductFixture $productFixture;

    /**
     * Test if the "used product" block or snippet is present on the product page
     *
     * @magentoDataFixtureBeforeTransaction createUsedProduct
     * @magentoConfigFixture default_store used_product/main/enable 1
     * @magentoConfigFixture default_store used_product/main/enable_on_product_page 1
     */
    public function testIfUsedProductBlockIsPresentOnProductPage(): void
    {
        $productId = self::$productFixture->getId();
        $this->dispatch("catalog/product/view/id/{$productId}");
        $this->assertStringContainsString(
            'id="used-product"',
            $this->getResponse()->getBody(),
            'Expected "used-product" element not found in product page HTML.'
        );
    }

    /**
     * Test if the "used product" block or snippet is present on the product page
     *
     * @magentoDataFixtureBeforeTransaction createUsedProduct
     * @magentoConfigFixture default_store used_product/main/enable 0
     * @magentoConfigFixture default_store used_product/main/enable_on_product_page 1
     */
    public function testIfUsedProductBlockIsAbsentOnProductPageWhileModuleIsDisabled(): void
    {
        $productId = self::$productFixture->getId();
        $this->dispatch("catalog/product/view/id/{$productId}");
        $this->assertStringNotContainsString(
            'id="used-product"',
            $this->getResponse()->getBody(),
            'Expected "used-product" element not found in product page HTML.'
        );
    }

    /**
     * Test if the "used product" block or snippet is present on the product page
     *
     * @magentoDataFixtureBeforeTransaction createUsedProduct
     * @magentoConfigFixture default_store used_product/main/enable 1
     * @magentoConfigFixture default_store used_product/main/enable_on_product_page 0
     */
    public function testIfUsedProductBlockIsAbsentOnProductPageWhileModuleIsEnabledAndPDPIsDisabled(): void
    {
        $productId = self::$productFixture->getId();
        $this->dispatch("catalog/product/view/id/{$productId}");
        $this->assertStringNotContainsString(
            'id="used-product"',
            $this->getResponse()->getBody(),
            'Expected "used-product" element not found in product page HTML.'
        );
    }

    /**
     * Test if the "used product" block or snippet is **absent** on a non-used product page
     *
     * @magentoDataFixtureBeforeTransaction createNonUsedProduct
     * @magentoConfigFixture default_store used_product/main/enable 1
     * @magentoConfigFixture default_store used_product/main/enable_on_product_page 1
     */
    public function testIfUsedProductBlockIsAbsentOnNonUsedProductPage(): void
    {
        $productId = self::$productFixture->getId();
        $this->dispatch("catalog/product/view/id/{$productId}");
        $this->assertStringNotContainsString(
            'id="used-product"',
            $this->getResponse()->getBody(),
            'Did NOT expect "used-product" element on non-used product page HTML.'
        );
    }

    public static function createUsedProduct(): void
    {
        self::$productFixture = new ProductFixture(
            ProductBuilder::aSimpleProduct()
                ->withCustomAttributes(
                    [
                        'used_product' => true
                    ]
                )
                ->withStockQty(10)
                ->withIsInStock(true)
                ->build()
        );
    }

    public static function createNonUsedProduct(): void
    {
        self::$productFixture = new ProductFixture(
            ProductBuilder::aSimpleProduct()
                ->withCustomAttributes(
                    [
                        'used_product' => false
                    ]
                )
                ->withStockQty(10)
                ->withIsInStock(true)
                ->build()
        );
    }

    public static function createUsedProductRollback(): void
    {
        ProductFixtureRollback::create()->execute(self::$productFixture);
    }

    public static function createNonUsedProductRollback(): void
    {
        ProductFixtureRollback::create()->execute(self::$productFixture);
    }
}
