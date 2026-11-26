<?php

declare(strict_types=1);

namespace Smile\RetailerService\Block\Adminhtml\Service\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Smile\RetailerService\Block\Adminhtml\Service\Edit\AbstractButton;

class Save extends AbstractButton implements ButtonProviderInterface
{
    /**
     * Get the button data
     */
    public function getButtonData(): array
    {
        return [
            'label'          => __('Save Service'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order'     => 90,
        ];
    }
}
