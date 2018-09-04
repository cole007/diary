<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary\records;

use cole007\diary\Diary;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class Data extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diary_data}}';
    }
}
