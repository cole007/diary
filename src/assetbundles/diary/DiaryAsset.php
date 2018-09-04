<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary\assetbundles\Diary;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class DiaryAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@cole007/diary/assetbundles/diary/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Diary.js',
        ];

        $this->css = [
            'css/Diary.css',
        ];

        parent::init();
    }
}
