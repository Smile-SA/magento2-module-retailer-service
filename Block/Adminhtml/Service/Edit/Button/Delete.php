<?php

declare(strict_types=1);

namespace Smile\RetailerService\Block\Adminhtml\Service\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Smile\RetailerService\Block\Adminhtml\Service\Edit\AbstractButton;

class Delete extends AbstractButton implements ButtonProviderInterface
{
    /**
     * Get the button data
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getServiceId()) {
            $message = htmlentities(__('Are you sure you want to delete this Service ?')->render());

            $data = [
                'label'      => __('Delete Service'),
                'class'      => 'delete',
                'on_click'   => "deleteConfirm('{$message}', '{$this->getDeleteUrl()}')",
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * Get the delete URL.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getServiceId()]);
    }
}
