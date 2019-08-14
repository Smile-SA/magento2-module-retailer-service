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

namespace Smile\RetailerService\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Smile\RetailerService\Api\Data\ServiceInterface;

/**
 * Service schema install class.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->createServiceTable($setup);

        $setup->endSetup();
    }

    /**
     * Create the service table.
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup The Setup
     *
     * @throws \Zend_Db_Exception
     */
    private function createServiceTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(ServiceInterface::TABLE_NAME))
            ->addColumn(
                ServiceInterface::SERVICE_ID,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                ServiceInterface::NAME,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )
            ->addColumn(
                ServiceInterface::DESCRIPTION,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Description'
            )
            ->addColumn(
                ServiceInterface::STATUS,
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Status'
            )
            ->addColumn(
                ServiceInterface::MEDIA_PATH,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Media file path'
            )
            ->addColumn(
                ServiceInterface::RETAILER_ID,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Retailer ID'
            )
            ->addColumn(
                ServiceInterface::SORT,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true],
                'Sort'
            )
            ->addColumn(
                ServiceInterface::CREATED_AT,
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Creation Time'
            )
            ->addColumn(
                ServiceInterface::END_AT,
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'End at'
            )
            ->addForeignKey(
                $setup->getFkName(
                    ServiceInterface::TABLE_NAME,
                    ServiceInterface::RETAILER_ID,
                    'smile_seller_entity',
                    'entity_id'),
                ServiceInterface::RETAILER_ID,
                $setup->getTable('smile_seller_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );

        $setup->getConnection()->createTable($table);
    }
}
