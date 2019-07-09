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

namespace Smile\RetailerService\Model\Service\Form;

use Smile\RetailerService\Model\ResourceModel\Service\CollectionFactory;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * DataProvider
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Smile\RetailerService\Model\ResourceModel\Service\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string                 $name              Name.
     * @param string                 $primaryFieldName  Primary field name.
     * @param string                 $requestFieldName  Request field name.
     * @param CollectionFactory      $collectionFactory Collection.
     * @param DataPersistorInterface $dataPersistor     Data persistor.
     * @param array                  $meta              Meta.
     * @param array                  $data              Data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Smile\RetailerService\Model\Service $service */
        foreach ($items as $service) {
            $service->setData(ServiceInterface::MEDIA_PATH, $this->getMediaUrl($service));
            $this->loadedData[$service->getId()] = $service->getData();
        }

        $data = $this->dataPersistor->get('smile_retailer_service');
        if (!empty($data)) {
            $service = $this->collection->getNewEmptyItem();
            $service->setData($data);

            $this->loadedData[$service->getId()] = $service->getData();
            $this->dataPersistor->clear('smile_retailer_service');
        }

        return $this->loadedData;
    }

    /**
     * Get media Url.
     *
     * @param ServiceInterface $service Service.
     *
     * @return array
     */
    protected function getMediaUrl($service)
    {
        return [
            0 => [
                'name' => $service->getMediaPath(),
                'url' => 'url'//$this->supplierHelper->getLogoUrl($service)
            ]
        ];
    }
}
