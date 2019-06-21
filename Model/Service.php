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

namespace Smile\RetailerService\Model;

use Smile\RetailerService\Api\Data\ServiceInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Service Model
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName) properties are inherited.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Service extends \Magento\Framework\Model\AbstractExtensibleModel implements ServiceInterface, IdentityInterface
{
    /**
     * @var string
     */
    const CACHE_TAG = self::TABLE_NAME;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Construct.
     */
    protected function _construct()
    {
        $this->_init(\Smile\RetailerService\Model\ResourceModel\Service::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->getData(self::SERVICE_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritDoc}
     */
    public function getMediaPath()
    {
        return $this->getData(self::MEDIA_PATH);
    }

    /**
     * {@inheritDoc}
     */
    public function getRetailerId()
    {
        return $this->getData(self::RETAILER_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getSort()
    {
        return $this->getData(self::SORT);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function getEndAt()
    {
        return $this->getData(self::END_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function setId($serviceId)
    {
        return $this->setData(self::SERVICE_ID, $serviceId);
    }

    /**
     * {@inheritDoc}
     */
    public function SetName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function SetDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * {@inheritDoc}
     */
    public function SetStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * {@inheritDoc}
     */
    public function SetMediaPath($path)
    {
        return $this->setData(self::MEDIA_PATH, $path);
    }

    /**
     * {@inheritDoc}
     */
    public function SetRetailerId($retailerId)
    {
        return $this->setData(self::RETAILER_ID, $retailerId);
    }

    /**
     * {@inheritDoc}
     */
    public function SetSort($sort)
    {
        return $this->setData(self::SORT, $sort);
    }

    /**
     * {@inheritDoc}
     */
    public function SetCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function SetEndAt($endAt)
    {
        return $this->setData(self::END_AT, $endAt);
    }
}
