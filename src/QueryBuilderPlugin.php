<?php
/**
 * Widen plugin for Craft CMS 3.x
 *
 * Widen DAM Field Type for  Craft 3
 *
 * @link      https://union.co
 * @copyright Copyright (c) 2020 UNION
 */

namespace unionco\querybuilder;

use Craft;
use craft\web\View;
use yii\base\Event;
use craft\base\Plugin;
use craft\web\UrlManager;
use craft\services\Fields;
use craft\services\Plugins;
use craft\events\PluginEvent;
use unionco\widen\client\Client;
use unionco\widen\services\Asset;
use unionco\widen\models\Settings;
use unionco\widen\services\Refresh;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterComponentTypesEvent;
use unionco\widen\services\Asset as AssetService;
use unionco\querybuilder\fields\QueryBuilderField;
use craft\console\Application as ConsoleApplication;
use nystudio107\pluginvite\services\VitePluginService;
use unionco\widen\fields\WidenAsset as WidenAssetField;
use unionco\querybuilder\variables\QueryBuilderVariable;
use unionco\querybuilder\assetbundles\querybuilder\QueryBuilderAsset;
/**
 * Class Widen
 *
 * @author    UNION
 * @package   Widen
 * @since     0.1.0
 *
 * @property  AssetService $asset
 */
class QueryBuilderPlugin extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Widen
     */
    public static $plugin;

    /** @var Client */
    protected static $client;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.1.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        Craft::setAlias('@querybuilder', $this->getBasePath());

        $this->setComponents([
            'queries' => Queries::class,
            'vite' => [
                'class' => VitePluginService::class,
                'assetClass' => QueryBuilderAsset::class,
                'useDevServer' => true,
                'devServerPublic' => 'http://127.0.0.1:3001',
                'serverPublic' => 'http://127.0.0.1:8000',
                'errorEntry' => '/src/js/app.ts',
                'devServerInternal' => 'http://127.0.0.1:3001',
                'checkDevServer' => true,
            ],
        ]);

            // Event::on(
            //     View::class,
            //     View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            //     function(RegisterTemplateRootsEvent $event) {
            //         $event->roots['querybuilder'] = __DIR__ . '/templates';
            //     }
            // );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('querybuilder', [
                    'class' => QueryBuilderVariable::class,
                    'viteService' => $this->vite,
                ]);
            }
        );

        // if (\Craft::$app instanceof ConsoleApplication) {
        //     $this->controllerNamespace = 'unionco\widen\console\controllers';
        // } else {
        //     $this->controllerNamespace = 'unionco\widen\controllers';
        // }

        // Event::on(
        //     UrlManager::class,
        //     UrlManager::EVENT_REGISTER_SITE_URL_RULES,
        //     function (RegisterUrlRulesEvent $event) {
        //         $event->rules['debug-widen'] = 'widen/refresh/debug';
        //     }
        // );

        // Event::on(
        //     UrlManager::class,
        //     UrlManager::EVENT_REGISTER_CP_URL_RULES,
        //     function (RegisterUrlRulesEvent $event) {
        //         $event->rules['widen/assets/query'] = 'widen/cp-asset/query';
        //     }
        // );

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = QueryBuilderField::class;
            }
        );

        // Event::on(
        //     Plugins::class,
        //     Plugins::EVENT_AFTER_INSTALL_PLUGIN,
        //     function (PluginEvent $event) {
        //         if ($event->plugin === $this) {
        //         }
        //     }
        // );

        // Craft::info(
        //     Craft::t(
        //         'widen',
        //         '{name} plugin loaded',
        //         ['name' => $this->name]
        //     ),
        //     __METHOD__
        // );
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
            'widen/settings',
            [
                'settings' => $this->getSettings(),
            ]
        );
    }
}
