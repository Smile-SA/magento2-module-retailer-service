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

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as CollectionProcessor;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\RetailerService\Api\Data\ServiceInterfaceFactory;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Api\Data\ServiceSearchResultsInterface;
use Smile\RetailerService\Api\Data\ServiceSearchResultsInterfaceFactory;
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\RetailerService\Model\ResourceModel\Service as ServiceResourceModel;
use Smile\RetailerService\Model\ResourceModel\Service\CollectionFactory as ServiceCollectionFactory;

/**
 * Service Repository
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @var ServiceInterfaceFactory
     */
    protected $objectFactory;

    /**
     * @var ServiceResourceModel
     */
    protected $objectResource;

    /**
     * @var ServiceSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessor
     */
    protected $collectionProcessor;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var ServiceCollectionFactory
     */
    protected $serviceCollectionFactory;
    /**
     * Item constructor.
     *
     * @param ServiceInterfaceFactory              $objectFactory
     * @param ServiceResourceModel                 $objectResource
     * @param ServiceSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessor                $collectionProcessor
     * @param FilterBuilder                      $filterBuilder
     * @param SearchCriteriaBuilder              $searchCriteriaBuilder
     * @param ServiceCollectionFactory             $serviceCollectionFactory
     */
    public function __construct(
        ServiceInterfaceFactory $objectFactory,
        ServiceResourceModel $objectResource,
        ServiceSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessor $collectionProcessor,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ServiceCollectionFactory $serviceCollectionFactory
    ) {
        $this->objectFactory            = $objectFactory;
        $this->objectResource           = $objectResource;
        $this->searchResultsFactory     = $searchResultsFactory;
        $this->collectionProcessor      = $collectionProcessor;
        $this->filterBuilder            = $filterBuilder;
        $this->searchCriteriaBuilder    = $searchCriteriaBuilder;
        $this->serviceCollectionFactory = $serviceCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($serviceId)
    {
        /** @var \Magento\Framework\Model\AbstractModel $object */
        $object = $this->objectFactory->create();
        $this->objectResource->load($object, $serviceId);

        if (!$object->getId()) {
            throw NoSuchEntityException::singleField('objectId', $serviceId);
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getByRetailerId($retailerId)
    {
        $this->searchCriteriaBuilder
            ->addFilter(ServiceInterface::RETAILER_ID, $retailerId);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->getList($searchCriteria);

        $items = $searchResult->getItems();
        if (empty($items)) {
            throw NoSuchEntityException::singleField(OfferInterface::SKU_COLUMN_NAME, $retailerId);
        }

        return reset($items);
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Smile\RetailerService\Model\ResourceModel\Service\Collection $collection */
        $collection = $this->serviceCollectionFactory->create();

        $searchResults = $this->searchResultsFactory->create();
        if ($searchCriteria) {
            $searchResults->setSearchCriteria($searchCriteria);
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $collection->load();
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ServiceInterface $service)
    {
        try {
            $this->objectResource->save($service);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $service;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ServiceInterface $service)
    {
        try {
            $this->objectResource->delete($service);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($serviceId)
    {
        $this->delete($this->get($serviceId));
    }
}
