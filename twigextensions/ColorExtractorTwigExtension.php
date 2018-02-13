<?php

namespace Craft;

class ColorExtractorTwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return Craft::t('Color Extractor');
    }

    public function getFilters()
    {
        return array(
            'colorExtractor' => new \Twig_Filter_Method($this, 'colorExtractorFilter')
        );
    }

    public function colorExtractorFilter($image)
    {
        return craft()->colorExtractor_asset->getImageColor($image);
    }
}
