<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary;

use cole007\diary\services\User as UserService;
use cole007\diary\services\Data as DataService;
use cole007\diary\services\Notify as NotifyService;
use cole007\diary\variables\DiaryVariable;
use cole007\diary\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Diary
 *
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 *
 * @property  UserService $user
 * @property  DataService $data
 * @property  NotifyService $notify
 */
class Diary extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Diary
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'diary/user';
                $event->rules['siteActionTrigger2'] = 'diary/data';
                $event->rules['siteActionTrigger3'] = 'diary/notify';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'diary/user/do-something';
                $event->rules['cpActionTrigger2'] = 'diary/data/do-something';
                $event->rules['cpActionTrigger3'] = 'diary/notify/do-something';
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('diary', DiaryVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'diary',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'diary/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
