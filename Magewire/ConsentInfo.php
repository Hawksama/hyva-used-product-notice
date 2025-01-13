<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\UsedProductNotice\Magewire;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\Quote;
use Magento\Catalog\Model\Product;
use Magewirephp\Magewire\Component;
use Hyva\Checkout\Model\Magewire\Component\EvaluationResultInterface;
use Hyva\Checkout\Model\Magewire\Component\EvaluationResultFactory;
use Hyva\Checkout\Model\Magewire\Component\EvaluationInterface;
use Hawksama\UsedProductNotice\Model\Config;

class ConsentInfo extends Component implements EvaluationInterface
{
    /**
     * @var Quote|null
     */
    protected ?Quote $quote = null;

    /**
     * @var array
     */
    public $listeners = ['consent_for_used_product_updated' => 'hideIfHasConsent'];

    public function __construct(
        private CheckoutSession $checkoutSession,
        private Config $config,
        public array $productNames = [],
        public bool $hidden = true,
        public bool $checked = false
    ) {
    }

    public function mount(): void
    {
        if ($this->config->isEnabledConfirmationOnCheckout()) {
            $quote = $this->getQuote();

            foreach ($quote->getAllVisibleItems() as $item) {
                if ($this->checkUsedProduct($item->getProduct())) {
                    $this->productNames[] = $item->getName(); // Store product names
                    $this->hidden = false;
                    $this->checked = (bool)$this->checkoutSession->getConsentForUsedProductNotice();
                }
            }
        }
    }

    public function checkUsedProduct(Product $product): bool
    {
        $usedProduct = $product->getCustomAttribute('used_product');
        return $usedProduct && (bool)$usedProduct->getValue();
    }

    private function getQuote(): Quote
    {
        if (null === $this->quote) {
            $this->quote = $this->checkoutSession->getQuote();
        }
        return $this->quote;
    }

    public function getProductNames(): array
    {
        return $this->productNames;
    }

    public function updatedChecked(bool $value): bool
    {
        $this->checkoutSession->setConsentForUsedProductNotice($value);

        return $value;
    }

    public function evaluateCompletion(EvaluationResultFactory $resultFactory): EvaluationResultInterface
    {
        if (!$this->hidden && $this->checked) {
            return $resultFactory->createSuccess();
        }

        if (!empty($this->productNames)) {
            $productList = implode(', ', $this->productNames);

            return $resultFactory->createValidation('validateConsentForUsedProductNoticeComponent')
                ->withFailureResult(
                    $resultFactory->createErrorMessageEvent()
                        ->withMessage(
                            (string)__(
                                'Acknowledge that these products have no warranty or return policy: %1',
                                $productList
                            )
                        )
                        ->asWarning()
                        ->withCustomEvent('quote:actions:error')
                );
        }

        return $resultFactory->createErrorMessage();
    }
}
