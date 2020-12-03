<?php

namespace statuo\GoogleShoppingFeed;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use statuo\GoogleShoppingFeed\models\Settings;
use statuo\GoogleShoppingFeed\variables\GoogleShoppingFeedVariable;
use yii\base\Event;

class GoogleShoppingFeed extends Plugin
{
    public static $plugin;
    public $schemaVersion = '1.0.0';

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->_registerRoutes();
        $this->_registerVariables();
    }

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'google-shopping-feed/settings',
            [
                'settings' => $this->getSettings(),
                'fields' => Craft::$app->getFields()->getAllFields()
            ]
        );
    }

    private function _registerRoutes(): void
    {
        if (Craft::$app->getPlugins()->isPluginEnabled('commerce')) {
            Event::on(
                UrlManager::class,
                UrlManager::EVENT_REGISTER_SITE_URL_RULES,
                function (RegisterUrlRulesEvent $event) {
                    $event->rules[$this->getSettings()->shoppingFeed] = 'google-shopping-feed/feed';
                }
            );
        }
    }

    private function _registerVariables(): void
    {
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('googleshopping', GoogleShoppingFeedVariable::class);
            }
        );
    }
}