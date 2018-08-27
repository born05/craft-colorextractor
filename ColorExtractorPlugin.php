<?php
namespace Craft;

class ColorExtractorPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Color Extractor');
    }

    public function getVersion()
    {
        return '1.0.7';
    }

    public function getSchemaVersion()
    {
        return '1.0.5';
    }

    public function getDeveloper()
    {
        return 'Born05';
    }

    public function getDeveloperUrl()
    {
        return 'http://www.born05.com/';
    }

    public function getPluginUrl()
    {
        return 'https://github.com/born05/craft-colorextractor';
    }

    public function getDocumentationUrl()
    {
        return $this->getPluginUrl() . '/blob/craft-2/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/born05/craft-colorextractor/craft-2/releases.json';
    }

    public function init()
    {
        craft()->on('assets.onReplaceFile', [craft()->colorExtractor_assetUpload, 'onReplaceFile']);
        craft()->on('assets.onSaveAsset', [craft()->colorExtractor_assetUpload, 'onSaveAsset']);
    }

    public function onAfterInstall()
    {
        craft()->colorExtractor_assetUpload->processImages();
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.colorextractor.twigextensions.ColorExtractorTwigExtension');

        return new ColorExtractorTwigExtension();
    }
}
