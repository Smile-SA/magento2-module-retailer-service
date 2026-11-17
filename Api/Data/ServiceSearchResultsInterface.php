<?php

declare(strict_types=1);

namespace Smile\RetailerService\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for service search results.
 *
 * @api
 */
interface ServiceSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get services list.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface[]
     */
    public function getItems();

    /**
     * Set services list.
     *
     * @param \Smile\RetailerService\Api\Data\ServiceInterface[] $items The items
     * @return $this
     */
    public function setItems(array $items);
}
