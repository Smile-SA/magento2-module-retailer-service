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

/**
 * Data Api for Services
 *
 * @api
 */
interface ServiceInterface
{
    /**
     * The table name
     */
    const TABLE_NAME  = 'smile_retailer_service';

    /**
     * The service Id field
     */
    const SERVICE_ID  = 'service_id';

    /**
     * The service name field
     */
    const NAME        = 'name';

    /**
     * The service description field
     */
    const DESCRIPTION = 'description';

    /**
     * The service status field
     */
    const STATUS      = 'status';

    /**
     * The service media_path field
     */
    const MEDIA_PATH  = 'media_path';

    /**
     * The service retailer_id field
     */
    const RETAILER_ID = 'retailer_id';

    /**
     * The service sort field
     */
    const SORT        = 'sort';

    /**
     * The service created_at field
     */
    const CREATED_AT  = 'created_at';

    /**
     * The service end_at field
     */
    const END_AT      = 'end_at';

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get status.
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get media path.
     *
     * @return string|null
     */
    public function getMediaPath();

    /**
     * Get retailer id.
     *
     * @return int|null
     */
    public function getRetailerId();

    /**
     * Get sort.
     *
     * @return int|null
     */
    public function getSort();

    /**
     * Get created at.
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get end at.
     *
     * @return string|null
     */
    public function getEndAt();

    /**
     * Set ID.
     *
     * @param int $serviceId Service ID.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetId($serviceId);

    /**
     * Set name.
     *
     * @param string $name Name.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetName($name);

    /**
     * Set description.
     *
     * @param string $description Description.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetDescription($description);

    /**
     * Set status.
     *
     * @param int $status Status.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetStatus($status);

    /**
     * Set media path.
     *
     * @param string $path Media file path;
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetMediaPath($path);

    /**
     * Set retailer id.
     *
     * @param int $retailerId Retailer Id.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetRetailerId($retailerId);

    /**
     * Set sort.
     *
     * @param int $sort Sort.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetSort($sort);

    /**
     * Set created at.
     *
     * @param string $createdAt Created at.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetCreatedAt($createdAt);

    /**
     * Set end at.
     *
     * @param string $endAt End at.
     *
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function SetEndAt($endAt);
}
