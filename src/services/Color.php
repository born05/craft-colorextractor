<?php

namespace born05\colorextractor\services;

use League\ColorExtractor\Color as LeagueColor;

use Craft;
use craft\base\Component;
use craft\elements\Asset as AssetElement;

class Color extends Component
{
    public function isDark(string $color)
    {
        $intColor = LeagueColor::fromHexToInt($color);
        $rgbColor = LeagueColor::fromIntToRgb($intColor);

        $darkness = 1 - (0.299 * $rgbColor['r'] + 0.587 * $rgbColor['g'] + 0.114 * $rgbColor['b']) / 255;

        return $darkness >= 0.5;
    }
}
