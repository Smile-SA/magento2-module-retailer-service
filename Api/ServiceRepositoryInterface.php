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

namespace Smile\RetailerService\Api;

/**
 * Service Repository Interface
 *
 * @api
 */
interface ServiceRepositoryInterface
{
    /**
     * Retrieve service by id
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $serviceId Service id.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function get($serviceId);

    /**
     * Retrieve service by retailer id
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $retailerId retailer id.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function getByRetailerId($retailerId);

    /**
     * Retrieve services matching the specified criteria.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria The search criteria
     *
     * @return \Smile\RetailerService\Api\Data\ServiceSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Save service.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Smile\RetailerService\Api\Data\ServiceInterface $service The service

     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function save(Data\ServiceInterface $service);

    /**
     * Delete service.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Smile\RetailerService\Api\Data\ServiceInterface $service The service
     *
     * @return bool true on success
     */
    public function delete(Data\ServiceInterface $service);

    /**
     * Delete service by ID.
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $serviceId The service Id
     *
     * @return bool true on success
     */
    public function deleteById($serviceId);
}
