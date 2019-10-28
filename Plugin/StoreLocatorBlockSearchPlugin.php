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

    private $serviceRepositoryInterface;
    /**
     * Constructor.
     * @param array                                                          $data                      Additional data.
     */
    public function __construct(
        \Smile\StoreLocator\Helper\Data $storeLocatorHelper,
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
     * @param \Smile\Storelocator\Block\Search $block  The block search
     * @param array                            $result List of markers
     *
     * @return array
     */
    public function afterGetMarkers(\Smile\StoreLocator\Block\Search $block, $result)
    {
        if (!empty($result)) {
            foreach ($result as $key => $marker) {
                $servicesList = $this->getServiceListByRetailerId($marker['id']);
                $imageUrlService = $block->getImageUrl().'/retailerservice/';
                foreach ($servicesList as $services) {

                    $result[$key]['service'][] =
                        [
                            'media'         => $imageUrlService.$services->getMediaPath(),
                            'title'         => $services->getName(),
                            'description'   => $services->getDescription(),
                        ];
                }
            }
        }

        return $result;
    }

    public function getServiceListByRetailerId($retailerId)
    {
        $this->searchCriteriaBuilder
            ->addFilter(ServiceInterface::RETAILER_ID, $retailerId)
            ->addFilter(ServiceInterface::SORT, 1);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->serviceRepositoryInterface->getList($searchCriteria);

        $items = $searchResult->getItems();

        return $items;
    }
}