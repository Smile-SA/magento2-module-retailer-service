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
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\RetailerService\Api\Data\ServiceInterface;

class StoreLocatorBlockSearchPlugin
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ServiceRepositoryInterface
     */
    private $serviceRepositoryInterface;

    /**
     * StoreLocatorBlockSearchPlugin constructor.
     * @param ServiceRepositoryInterface $serviceRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        ServiceRepositoryInterface $serviceRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        $data = []
    ) {
        $this->serviceRepositoryInterface = $serviceRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    /**
     * Add Service in markers.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter).
     *
     * @param \Smile\StoreLocator\Block\Search  $block  The block search
     * @param $result                           $result List of markers
     * @return array
     */
    public function afterGetMarkers(\Smile\StoreLocator\Block\Search $block, $result)
    {
        if (!empty($result)) {
            foreach ($result as $key => $marker) {
                $servicesList = $this->getServiceListByRetailerId($marker['id']);
                $imageUrlService = $block->getImageUrl().'/retailerservice/';
                foreach ($servicesList as $services) {
                    $image = $services->getMediaPath() ? $imageUrlService.$services->getMediaPath() : false;
                    $result[$key]['service'][] =
                        [
                            'media'         => $image,
                            'title'         => $services->getName(),
                            'description'   => $services->getDescription(),
                        ];
                }
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
        $this->searchCriteriaBuilder
            ->addFilter(ServiceInterface::RETAILER_ID, $retailerId)
            ->addFilter(ServiceInterface::SORT, 1)
            ->addFilter(ServiceInterface::STATUS, 1);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->serviceRepositoryInterface->getList($searchCriteria);

        $items = $searchResult->getItems();

        return $items;
    }
}
