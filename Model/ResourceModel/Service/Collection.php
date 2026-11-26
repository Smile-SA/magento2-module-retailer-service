<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model\ResourceModel\Service;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Smile\RetailerService\Model\Service;

/**
 * Service Collection class
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName) Method is inherited.
     */
    protected function _construct(): void
    {
        $this->_init(
            Service::class,
            \Smile\RetailerService\Model\ResourceModel\Service::class
        );
    }
}
