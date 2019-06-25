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
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $block) {
            $this->loadedData[$block->getId()] = $block->getData();
        }

        $data = $this->dataPersistor->get('smile_retailer_service');
        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$block->getId()] = $block->getData();
            $this->dataPersistor->clear('smile_retailer_service');
        }

        return $this->loadedData;
    }
}
