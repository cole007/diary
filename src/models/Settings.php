<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary\models;

use cole007\diary\Diary;

use Craft;
use craft\base\Model;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $twilioNumber;
    public $twilioSid;
    public $twilioToken;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['twilioNumber','twilioSid','twilioToken'], 'string']
        ];
    }
}
