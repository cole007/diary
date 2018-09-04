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
use cole007\diary\records\User AS UserRecord;
use craft\validators\UniqueValidator;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class User extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $email,
        $name,
        $sms,
        $status,
        $password;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','name','sms','password','status'], 'string'],
            [['email','sms','password'], 'required']
        ];
    }
}
