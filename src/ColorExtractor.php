<?php

namespace born05\colorextractor;

use born05\colorextractor\twigextensions\ColorExtractorTwigExtension;

use Craft;
use craft\base\Plugin;
use craft\elements\Asset;
use craft\services\Assets;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\ModelEvent;
use craft\events\ReplaceAssetEvent;
use craft\console\Application as ConsoleApplication;

use yii\base\Event;

class ColorExtractor extends Plugin
{
    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Plugin::$plugin
     *
     * @var Plugin
     */
    public static ColorExtractor $plugin;

    public string $schemaVersion = '2.0.0';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        if (!$this->isInstalled) return;

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
            Asset::class,
            Asset::EVENT_AFTER_SAVE,
            function (ModelEvent $event) {
                if ($event->isNew) {
                    /** @var Asset $element */
                    $asset = $event->sender;
                    $this->assetUpload->onSaveAsset($asset);
                }
            }
        );
    }
}
