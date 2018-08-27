<?php

namespace born05\colorextractor;

use born05\colorextractor\services\Asset as AssetService;
use born05\colorextractor\services\AssetUpload as AssetUploadService;
use born05\colorextractor\twigextensions\ColorExtractorTwigExtension;

use Craft;
use craft\base\Plugin;
use craft\elements\Asset;
use craft\services\Assets;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\GetAssetUrlEvent;
use craft\events\ReplaceAssetEvent;
use craft\console\Application as ConsoleApplication;

use yii\base\Event;

class ColorExtractor extends Plugin
{
    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * ColorExtractor::$plugin
     *
     * @var ColorExtractor
     */
    public static $plugin;

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '2.0.0';

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Add in our Twig extensions
        Craft::$app->view->registerTwigExtension(new ColorExtractorTwigExtension());

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'born05\colorextractor\console\controllers';
        }

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                    $this->assetUpload->processImages();
                }
            }
        );

        Event::on(
            Assets::class,
            Assets::EVENT_AFTER_REPLACE_ASSET,
            function (ReplaceAssetEvent $event) {
                /** @var Asset $element */
                $asset = $event->asset;
                $this->assetUpload->onReplaceFile($asset);
            }
        );

        Event::on(
            Assets::class,
            Assets::EVENT_GET_ASSET_URL,
            function (GetAssetUrlEvent $event) {
                /** @var Asset $element */
                $asset = $event->asset;
                $this->assetUpload->onSaveAsset($asset);
            }
        );
    }
}
