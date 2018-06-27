<?php

namespace Nitesh\Singh\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 *
 * @package Nitesh\Post\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install Blog Posts table
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = $setup->getTable('nitesh_singh');
        

        if ($setup->getConnection()->isTableExists($tableName) != true) {
            $table = $setup->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'singh_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'singh_name',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Title'
                )
                ->addColumn(
                    'singh_start_date',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Start Date'
                )
                ->addColumn(
                    'singh_end_date',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'End Date'
                )
                ->addColumn(
                    'singh_trip_duration',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Trip Duration'
                )
                ->addColumn(
                    'singh_start_point',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Start Point'
                )
                ->addColumn(
                    'singh_end_point',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'End Point'
                )
                ->addColumn(
                    'singh_vehicle_name',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Vehicle Name'
                )

                ->addColumn(
                    'singh_describing',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Start Describing'
                )
                ->addColumn(
                    'singh_url',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Image / Videos'
                )

                ->addColumn(
                    'singh_slug',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Slug'
                )

                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )

                ->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    [

                        'nullable' => false,

                    ],
                    'User ID'
                )
                ->addColumn(
                    'singh_featured',
                    Table::TYPE_INTEGER,
                    null,
                    [

                        'nullable' => false,

                    ],
                    'Singh Featured'
                )

                ->setComment('Nitesh Post');
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
