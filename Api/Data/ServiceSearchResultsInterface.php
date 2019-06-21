<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerService
 * @author    Fanny DECLERCK <fadec@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

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
     *
     * @return $this
     */
    public function setItems(array $items);
}
