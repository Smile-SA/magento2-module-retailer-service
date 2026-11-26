<?php

declare(strict_types=1);

namespace Smile\RetailerService\Plugin;

use DateTime;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\StoreLocator\Block\View\Map;

class StoreLocatorBlockViewMapPlugin
{
    public const SERVICE_LIMIT = 4;

    public function __construct(
        private ServiceRepositoryInterface $serviceRepositoryInterface,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private FilterBuilder $filterBuilder,
        private FilterGroupBuilder $filterGroupBuilder,
        private SortOrderBuilder $sortOrderBuilder
    ) {
    }

    /**
     * Add Service in markers.
     *
     * @param Map $block The block search
     * @param array|null $result List of markers
     */
    public function afterGetMarkerData(Map $block, ?array $result): ?array
    {
        if (!empty($result)) {
            $l = $result[0]['id'];
            $servicesList = $this->getServiceListByRetailerId((int) $l);
            $imageUrlService = $block->getImageUrl() . '/retailerservice/';
            foreach ($servicesList as $services) {
                $image = $services->getMediaPath() ? $imageUrlService . $services->getMediaPath() : false;
                $result[0]['service'][] =
                    [
                        'media'         => $image,
                        'title'         => $services->getName(),
                        'description'   => $services->getDescription(),
                    ];
            }
        }

        return $result;
    }

    /**
     * Get the active services of a retailer.
     *
     * @return ServiceInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getServiceListByRetailerId(int $retailerId): array
    {
        $now = new DateTime();
        $currDateFormat = $now->format('Y-m-d');

        $retailerIdFilter = $this->filterBuilder
            ->setField(ServiceInterface::STATUS)
            ->setConditionType('eq')
            ->setValue('1')
            ->create();
        $retailerStatusFilter = $this->filterBuilder
            ->setField(ServiceInterface::RETAILER_ID)
            ->setConditionType('eq')
            ->setValue((string) $retailerId)
            ->create();
        $retailerEndDate = $this->filterBuilder
            ->setField(ServiceInterface::END_AT)
            ->setConditionType('gteq')
            ->setValue($currDateFormat)
            ->create();
        $retailerCurrentDate = $this->filterBuilder
            ->setField(ServiceInterface::CREATED_AT)
            ->setConditionType('eq')
            ->setValue($currDateFormat)
            ->create();
        $retailerCurrentDateEnd = $this->filterBuilder
            ->setField(ServiceInterface::END_AT)
            ->setConditionType('eq')
            ->setValue($currDateFormat)
            ->create();
        $retailerStartDate = $this->filterBuilder
            ->setField(ServiceInterface::CREATED_AT)
            ->setConditionType('lteq')
            ->setValue($currDateFormat)
            ->create();
        $retailerEmptyEnd = $this->filterBuilder
            ->setField(ServiceInterface::END_AT)
            ->setConditionType('null')
            ->create();
        $retailerEmptyStart = $this->filterBuilder
            ->setField(ServiceInterface::CREATED_AT)
            ->setConditionType('null')
            ->create();
        $sortOrderServices = $this->sortOrderBuilder
            ->setField(ServiceInterface::SORT)
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        /** @var \Magento\Framework\Api\Search\FilterGroup[] $filterGroup */
        $filterGroup = [
            $this->filterGroupBuilder
                ->addFilter($retailerIdFilter)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerStatusFilter)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerStartDate)
                ->addFilter($retailerCurrentDate)
                ->addFilter($retailerEmptyStart)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerEndDate)
                ->addFilter($retailerCurrentDateEnd)
                ->addFilter($retailerEmptyEnd)
                ->create(),
        ];

        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups($filterGroup)
            ->setSortOrders([$sortOrderServices])
            ->setPageSize(self::SERVICE_LIMIT)
            ->create();
        $searchResult = $this->serviceRepositoryInterface->getList($searchCriteria);

        $items = $searchResult->getItems();

        return $items;
    }
}
