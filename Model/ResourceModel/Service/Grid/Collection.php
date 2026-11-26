<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model\ResourceModel\Service\Grid;

use Magento\Customer\Ui\Component\DataProvider\Document;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Model\ResourceModel\Service;

/**
 * Service grid Collection class
 */
class Collection extends SearchResult
{
    /**
     * @inheritdoc
     */
    protected $document = Document::class;

    /**
     * @inheritdoc
     */
    // @codingStandardsIgnoreStart - ignore variable with underscore prefix
    protected $_map = ['fields' => ['entity_id' => 'main_table.'.ServiceInterface::SERVICE_ID]];
    // @codingStandardsIgnoreEnd

    /**
     * Collection constructor.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    // phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found -- adds default table/resource model
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        string $mainTable = ServiceInterface::TABLE_NAME,
        string $resourceModel = Service::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
}
