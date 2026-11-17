<?php

declare(strict_types=1);

namespace Smile\RetailerService\Block\Adminhtml\Service\Edit;

use Magento\Backend\Block\Widget\Context;
use Smile\RetailerService\Api\ServiceRepositoryInterface;

/**
 * AbstractButton class
 *
 * @category Smile
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
abstract class AbstractButton
{
    /**
     * AbstractButton constructor.
     *
     * @param Context                    $context          Context.
     * @param ServiceRepositoryInterface $objectRepository Service Repository.
     */
    public function __construct(
        protected Context $context,
        protected ServiceRepositoryInterface $objectRepository
    ) {
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route  Route.
     * @param   array  $params Params.
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return service Id.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getServiceId(): ?int
    {
        $id = $this->context->getRequest()->getParam('id', false);

        if ($id) {
            return (int) $this->objectRepository->get((int) $id)->getId();
        }

        return null;
    }

    /**
     * Get the button data
     */
    abstract public function getButtonData(): array;
}
