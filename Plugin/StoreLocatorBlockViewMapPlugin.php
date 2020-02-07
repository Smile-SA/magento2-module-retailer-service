<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerService
 * @author    Ihor KVASNYTSKYI <ihor.kvasnytskyi@smile-ukraine.com>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\RetailerService\Plugin;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SortOrderBuilder;

class StoreLocatorBlockViewMapPlugin
{
    const SERVICE_LIMIT = 4;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ServiceRepositoryInterface
     */
    private $serviceRepositoryInterface;

    /**
     * @var FilterBuilder
     */

    private $filterBuilder;
    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * StoreLocatorBlockSearchPlugin constructor.
     * @param ServiceRepositoryInterface $serviceRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        ServiceRepositoryInterface $serviceRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->serviceRepositoryInterface = $serviceRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }


    /**
     * Add Service in markers.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter).
     *
     * @param \Smile\StoreLocator\Block\View\Map  $block  The block search
     * @param $result                           $result List of markers
     * @return array
     */
    public function afterGetMarkerData(\Smile\StoreLocator\Block\View\Map $block, $result)
    {
        if (!empty($result)) {
            $l = $result[0]['id'];
            $servicesList = $this->getServiceListByRetailerId($l);
            $imageUrlService = $block->getImageUrl().'/retailerservice/';
            foreach ($servicesList as $services) {
                $image = $services->getMediaPath() ? $imageUrlService.$services->getMediaPath() : false;
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
     * @param $retailerId
     * @return ServiceInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getServiceListByRetailerId($retailerId)
    {
        $now = new \DateTime();
        $currDateFormat = $now->format('Y-m-d');

        $retailerIdFilter = $this->filterBuilder
            ->setField(ServiceInterface::STATUS)
            ->setConditionType('eq')
            ->setValue(1)
            ->create();
        $retailerStatusFilter = $this->filterBuilder
            ->setField(ServiceInterface::RETAILER_ID)
            ->setConditionType('eq')
            ->setValue($retailerId)
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
                ->create()
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
