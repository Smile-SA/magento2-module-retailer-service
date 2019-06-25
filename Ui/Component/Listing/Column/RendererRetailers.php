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

namespace Smile\RetailerService\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Smile\Retailer\Api\RetailerRepositoryInterface;

/**
 * RendererRetailers class.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class RendererRetailers extends Column
{
    /** @var RetailerRepositoryInterface */
    protected $retailerRepository;

    /**
     * @param ContextInterface             $context            Application context
     * @param UiComponentFactory           $uiComponentFactory Ui Component Factory
     * @param RetailerRepositoryInterface  $retailerRepository Retailer repository.
     * @param array                        $components         Components
     * @param array                        $data               Component Data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        RetailerRepositoryInterface $retailerRepository,
        array $components = [],
        array $data = []
    ) {
        $this->retailerRepository = $retailerRepository;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource The data source
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$this->getData('name')])) {
                    $retailerName = $this->retailerRepository->get($item[$this->getData('name')]);
                    $item[$this->getData('name')] = $retailerName->getName();
                }
            }
        }

        return $dataSource;
    }
}