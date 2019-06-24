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

namespace Smile\RetailerService\Ui\Component\Listing;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as BaseDataProvider;

/**
 * DataProvider class.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class DataProvider extends BaseDataProvider
{
    /**
     * Constructor.
     *
     * @param string                $name                  Name.
     * @param string                $primaryFieldName      Primary Field Name.
     * @param string                $requestFieldName      Request Field Name.
     * @param Reporting             $reporting             Reporting.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder Search Criteria Builder.
     * @param RequestInterface      $request               Request Interface.
     * @param FilterBuilder         $filterBuilder         Filter Builder.
     * @param array                 $meta                  Meta.
     * @param array                 $data                  Data.
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Reporting $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }
}
