<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\RetailerService\Api\Data\ServiceInterface;

/**
 * Service Model
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName) properties are inherited.
 */
class Service extends AbstractModel implements ServiceInterface, IdentityInterface
{
    public const CACHE_TAG = self::TABLE_NAME;

    // phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Construct.
     */
    protected function _construct(): void
    {
        $this->_init(\Smile\RetailerService\Model\ResourceModel\Service::class);
    }

    /**
     * Get identities
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::SERVICE_ID);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function getMediaPath()
    {
        return $this->getData(self::MEDIA_PATH);
    }

    /**
     * @inheritdoc
     */
    public function getRetailerId()
    {
        return $this->getData(self::RETAILER_ID);
    }

    /**
     * @inheritdoc
     */
    public function getSort()
    {
        return $this->getData(self::SORT);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function getEndAt()
    {
        return $this->getData(self::END_AT);
    }

    /**
     * @inheritdoc
     */
    public function setId($serviceId)
    {
        return $this->setData(self::SERVICE_ID, $serviceId);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritdoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritdoc
     */
    public function setMediaPath($path)
    {
        return $this->setData(self::MEDIA_PATH, $path);
    }

    /**
     * @inheritdoc
     */
    public function setRetailerId($retailerId)
    {
        return $this->setData(self::RETAILER_ID, $retailerId);
    }

    /**
     * @inheritdoc
     */
    public function setSort($sort)
    {
        return $this->setData(self::SORT, $sort);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     */
    public function setEndAt($endAt)
    {
        return $this->setData(self::END_AT, $endAt);
    }
}
