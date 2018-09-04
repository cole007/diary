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
class Notify extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $to, 
        $status, 
        $token, 
        $message;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to','status','token'], 'string'],
            ['message', 'mixed']
        ];
    }
}
