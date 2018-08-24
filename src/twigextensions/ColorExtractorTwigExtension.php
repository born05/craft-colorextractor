<?php

namespace born05\colorextractor\twigextensions;

use born05\colorextractor\ColorExtractor;

use Craft;

class ColorExtractorTwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'Color Extractor';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ asset | colorExtractor }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('colorExtractor', [$this, 'colorExtractorFilter']),
        ];
    }

    /**
     * @param null $asset
     *
     * @return string
     */
    public function colorExtractorFilter($asset)
    {
        return ColorExtractor::$plugin->asset->getImageColor($asset);
    }
}
