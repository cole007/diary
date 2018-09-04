<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary\migrations;

use cole007\diary\Diary;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%diary_user}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%diary_user}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'email' => $this->string(255)->notNull(),
                    'name' => $this->string(255)->notNull(),
                    'password' => $this->string(255)->notNull(),
                ]
            );
        }

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%diary_data}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%diary_data}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'mood' => $this->integer(),
                    'period' => $this->integer(),
                    'energy' => $this->integer(),
                    'sleep' => $this->integer(),
                    'diet' => $this->text(),
                ]
            );
        }

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%diary_notify}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%diary_notify}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'email' => $this->string(255)->notNull()->defaultValue(''),
                    'status' => $this->string(255)->notNull()->defaultValue(''),
                    'token' => $this->string(255)->notNull()->defaultValue(''),
                    'message' => $this->text()->notNull()->defaultValue(''),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(
            $this->db->getIndexName(
                '{{%diary_user}}',
                'some_field',
                true
            ),
            '{{%diary_user}}',
            'some_field',
            true
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }

        $this->createIndex(
            $this->db->getIndexName(
                '{{%diary_data}}',
                'some_field',
                true
            ),
            '{{%diary_data}}',
            'some_field',
            true
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }

        $this->createIndex(
            $this->db->getIndexName(
                '{{%diary_notify}}',
                'some_field',
                true
            ),
            '{{%diary_notify}}',
            'some_field',
            true
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%diary_user}}', 'siteId'),
            '{{%diary_user}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%diary_data}}', 'siteId'),
            '{{%diary_data}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%diary_notify}}', 'siteId'),
            '{{%diary_notify}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%diary_user}}');

        $this->dropTableIfExists('{{%diary_data}}');

        $this->dropTableIfExists('{{%diary_notify}}');
    }
}
