<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model\Service\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Model\ResourceModel\Service\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    // phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
    protected $collection;

    protected array $loadedData;

    /**
     * Constructor
     *
     * @param string                        $name              Name.
     * @param string                        $primaryFieldName  Primary field name.
     * @param string                        $requestFieldName  Request field name.
     * @param CollectionFactory             $collectionFactory Collection.
     * @param DataPersistorInterface        $dataPersistor     Data persistor.
     * @param StoreManagerInterface         $storeManager      Store manager.
     * @param array                         $meta              Meta.
     * @param array                         $data              Data.
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        protected DataPersistorInterface $dataPersistor,
        protected StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection    = $collectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     */
    public function getData(): array
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
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getMediaUrl(ServiceInterface $service): array
    {
        /** @var \Magento\Store\Model\Store $store */
        $store = $this->storeManager->getStore();
        $mediaUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return [
            0 => [
                'name' => $service->getMediaPath(),
                'url' => $mediaUrl . 'retailerservice/' . $service->getMediaPath(),
            ],
        ];
    }
}
