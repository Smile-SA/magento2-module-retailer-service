<?php

declare(strict_types=1);

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
    public const TABLE_NAME  = 'smile_retailer_service';

    /**
     * The service Id field
     */
    public const SERVICE_ID  = 'service_id';

    /**
     * The service name field
     */
    public const NAME        = 'name';

    /**
     * The service description field
     */
    public const DESCRIPTION = 'description';

    /**
     * The service status field
     */
    public const STATUS      = 'status';

    /**
     * The service media_path field
     */
    public const MEDIA_PATH  = 'media_path';

    /**
     * The service retailer_id field
     */
    public const RETAILER_ID = 'retailer_id';

    /**
     * The service sort field
     */
    public const SORT        = 'sort';

    /**
     * The service created_at field
     */
    public const CREATED_AT  = 'created_at';

    /**
     * The service end_at field
     */
    public const END_AT      = 'end_at';

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
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setId($serviceId);

    /**
     * Set name.
     *
     * @param string $name Name.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setName($name);

    /**
     * Set description.
     *
     * @param string $description Description.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setDescription($description);

    /**
     * Set status.
     *
     * @param int $status Status.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setStatus($status);

    /**
     * Set media path.
     *
     * @param string $path Media file path;
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setMediaPath($path);

    /**
     * Set retailer id.
     *
     * @param int $retailerId Retailer Id.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setRetailerId($retailerId);

    /**
     * Set sort.
     *
     * @param int $sort Sort.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setSort($sort);

    /**
     * Set created at.
     *
     * @param string $createdAt Created at.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set end at.
     *
     * @param string $endAt End at.
     * @return \Smile\RetailerService\Api\Data\ServiceInterface
     */
    public function setEndAt($endAt);
}
