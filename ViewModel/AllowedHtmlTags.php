<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\HyvaUsedProductNotice\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class AllowedHtmlTags implements ArgumentInterface
{
    private array $allowedHtmlTags = [
        'a',
        'br',
        'em',
        'strong',
        'p',
        'ul',
        'ol',
        'li',
        'span'
    ];

    public function getAllowedHtmlTags(): array
    {
        return $this->allowedHtmlTags;
    }
}
