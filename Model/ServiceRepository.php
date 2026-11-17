<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model;

use Exception;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Api\Data\ServiceInterfaceFactory;
use Smile\RetailerService\Api\Data\ServiceSearchResultsInterfaceFactory;
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\RetailerService\Model\ResourceModel\Service as ServiceResourceModel;
use Smile\RetailerService\Model\ResourceModel\Service\CollectionFactory as ServiceCollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * Item constructor.
     */
    public function __construct(
        protected ServiceInterfaceFactory $objectFactory,
        protected ServiceResourceModel $objectResource,
        protected ServiceSearchResultsInterfaceFactory $searchResultsFactory,
        protected CollectionProcessor $collectionProcessor,
        protected FilterBuilder $filterBuilder,
        protected SearchCriteriaBuilder $searchCriteriaBuilder,
        protected ServiceCollectionFactory $serviceCollectionFactory
    ) {
    }

    /**
     * @inheritdoc
     */
    public function get($serviceId)
    {
        /** @var \Smile\RetailerService\Model\Service $object */
        $object = $this->objectFactory->create();
        $this->objectResource->load($object, $serviceId);

        if (!$object->getId()) {
            throw NoSuchEntityException::singleField('objectId', $serviceId);
        }

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function getByRetailerId($retailerId)
    {
        $this->searchCriteriaBuilder
            ->addFilter(ServiceInterface::RETAILER_ID, $retailerId);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->getList($searchCriteria);

        $items = $searchResult->getItems();
        if (empty($items)) {
            throw NoSuchEntityException::singleField(ServiceInterface::NAME, $retailerId);
        }

        return reset($items);
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Smile\RetailerService\Model\ResourceModel\Service\Collection $collection */
        $collection = $this->serviceCollectionFactory->create();

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $this->collectionProcessor->process($searchCriteria, $collection);

        $collection->load();
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function save(ServiceInterface $service)
    {
        try {
            /** @var \Smile\RetailerService\Model\Service $service */
            $this->objectResource->save($service);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $service;
    }

    /**
     * @inheritdoc
     */
    public function delete(ServiceInterface $service)
    {
        try {
            /** @var \Smile\RetailerService\Model\Service $service */
            $this->objectResource->delete($service);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteById($serviceId)
    {
        return $this->delete($this->get($serviceId));
    }
}
