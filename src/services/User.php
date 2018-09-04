<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary\services;

use cole007\diary\Diary;
use cole007\diary\models\User AS UserModel;
use cole007\diary\records\User AS UserRecord;

use Craft;
use craft\base\Component;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class User extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function saveUser( UserModel $user )
    {
        $site = Craft::$app->getSites()->getCurrentSite();
        
        $userRecord = new UserRecord;
        $userRecord->siteId = $site->id;
        foreach($user AS $property => $value) {
            // echo $property;
            $userRecord->$property = $value;
        }
        $userRecord->save();
        $email = $this->sendEmail( $userRecord );
        // send email ??
        return $email;
    }
    public function sendEmail( UserRecord $user )
    {
        // Craft::dd( $user );
        return true;
    }
}
