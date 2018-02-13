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
        return '1.0';
    }

    public function getDeveloper()
    {
        return 'Born05';
    }

    public function getDeveloperUrl()
    {
        return 'https://www.born05.com/';
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
        Craft::import('plugins.colorExtractor.twigextensions.ColorExtractorTwigExtension');

        return new ColorExtractorTwigExtension();
    }
}
