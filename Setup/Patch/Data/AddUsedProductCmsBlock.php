<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\UsedProductNotice\Setup\Patch\Data;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

//@phpcs:disable Generic.Files.LineLength.TooLong
class AddUsedProductCmsBlock implements DataPatchInterface
{
    public function __construct(
        private readonly BlockFactory $blockFactory,
        private readonly BlockRepositoryInterface $blockRepository,
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Apply Data Patch
     */
    public function apply(): self
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $data = [
            'title' => 'Used Product Message',
            'identifier' => 'used_product_message',
            'content' => '<p><strong>PLEASE NOTE: THIS IS AN OUTLET ITEM WITHOUT RIGHT OF WITHDRAWAL.</strong></p>
<p>&nbsp;</p>
<p><em><strong>IMPORTANT INFORMATION:</strong></em></p>
<div class="message-success warning message">
<p><em>This product has been tested and found to be in good working order. Because this is a used item, you will not receive a guarantee and you cannot use the right of withdrawal.</em></p>
</div>',
            'is_active' => 1,
            'stores' => [0] // Set this to all stores
        ];

        try {
            $block = $this->blockFactory->create();
            $block->setData($data);
            $this->blockRepository->save($block);
        } catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
        }

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
