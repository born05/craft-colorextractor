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
        return '1.0.4';
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
        return $this->getPluginUrl() . '/blob/master/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/born05/craft-colorextractor/master/releases.json';
    }

    public function init()
    {
        craft()->on('assets.onReplaceFile', array(craft()->colorExtractor_assetUpload, 'onReplaceFile'));
        craft()->on('assets.onSaveAsset', array(craft()->colorExtractor_assetUpload, 'onSaveAsset'));
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
