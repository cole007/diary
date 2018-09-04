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

use Craft;
use craft\base\Component;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class Notify extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (Diary::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
