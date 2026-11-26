<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model\ResourceModel;

use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Model\ServiceMediaUpload;

/**
 * Service Resource Model
 */
class Service extends AbstractDb
{
    /**
     * Service constructor.
     *
     * @param Context            $context        Application Context
     * @param EntityManager      $entityManager  Entity Manager
     * @param MetadataPool       $metadataPool   Metadata Pool
     * @param DateTime           $dateTime       Datetime
     * @param ServiceMediaUpload $mediaUpload    Media upload
     * @param string             $connectionName Connection name
     */
    public function __construct(
        Context $context,
        protected EntityManager $entityManager,
        protected MetadataPool $metadataPool,
        protected DateTime $dateTime,
        protected ServiceMediaUpload $mediaUpload,
        ?string $connectionName = null
    ) {

        parent::__construct($context, $connectionName);
    }

    /**
     * @inheritdoc
     */
    public function getConnection()
    {
        return $this->metadataPool->getMetadata(ServiceInterface::class)->getEntityConnection();
    }

    /**
     * Load an service by a given field's value.
     *
     * @param \Magento\Framework\Model\AbstractModel $object The service
     * @param mixed                                  $value  The value
     * @param mixed                                  $field  The field, if any
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $serviceId = $this->getServiceId($object, $value, $field);
        if ($serviceId) {
            $this->entityManager->load($object, (string) $serviceId);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function save(AbstractModel $object)
    {
        foreach ([ServiceInterface::CREATED_AT, ServiceInterface::END_AT] as $field) {
            $value = !$object->getData($field) ? null : $this->dateTime->formatDate($object->getData($field));
            $object->setData($field, $value);
        }

        $this->entityManager->save($object);
        /** @var \Smile\RetailerService\Model\Service $object */
        $this->mediaUpload->removeMediaFromTmp($object);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);
        /** @var \Smile\RetailerService\Model\Service $object */
        $this->mediaUpload->removeMedia($object);

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            ServiceInterface::TABLE_NAME,
            ServiceInterface::SERVICE_ID
        );
    }

    /**
     * Retrieve service Id by field value
     *
     * @param \Magento\Framework\Model\AbstractModel $object The service
     * @param mixed                                  $value  The value
     * @param mixed                                  $field  The field
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getServiceId(AbstractModel $object, $value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(ServiceInterface::class);
        if ($field === null) {
            $field = ServiceInterface::SERVICE_ID;
        }

        $entityId = $value;

        if ($field != $entityMetadata->getIdentifierField()) {
            $select = $this->_getLoadSelect($field, $value, $object);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);

            $result = $this->getConnection()->fetchCol($select);
            $entityId = count($result) ? $result[0] : false;
        }

        return $entityId === false ? false : (int) $entityId;
    }
}
