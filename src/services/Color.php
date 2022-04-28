<?php

namespace born05\colorextractor\services;

use League\ColorExtractor\Color as LeagueColor;

use craft\base\Component;

class Color extends Component
{
    public function isDark(string $color)
    {
        $hexValues = str_split(ltrim($color, '#'), 2);
        $rgbColor = [
            'r' => hexdec($hexValues[0]),
            'g' => hexdec($hexValues[1]),
            'b' => hexdec($hexValues[2]),
        ];

        $darkness = 1 - (0.299 * $rgbColor['r'] + 0.587 * $rgbColor['g'] + 0.114 * $rgbColor['b']) / 255;

        return $darkness >= 0.5;
    }
}
