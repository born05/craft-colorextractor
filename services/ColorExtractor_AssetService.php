<?php
namespace Craft;

require_once craft()->path->getPluginsPath() . 'colorextractor/vendor/autoload.php';

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

class ColorExtractor_AssetService extends BaseApplicationComponent
{
    /**
     * Extract colors from asset image.
     * @param  AssetFileModel $asset
     * @return string
     */
    public function extractColor(AssetFileModel $asset)
    {
        $palette = Palette::fromFilename($asset->url);

        // an extractor is built from a palette
        $extractor = new ColorExtractor($palette);

        // it defines an extract method which return the most “representative” colors
        $colors = $extractor->extract(1);

        // colors are represented by integers
        return Color::fromIntToHex($colors[0]);
    }

    /**
     * Get image color
     * @param  AssetFileModel $asset
     * @param  string $colorFieldHandle
     * @return string
     */
    public function getImageColor(AssetFileModel $asset, $colorFieldHandle = 'imageColor', $forceSave = false)
    {
        $color = isset($asset[$colorFieldHandle]) ? $asset[$colorFieldHandle] : null;

        if (empty($color) || $forceSave) {
            $color = $this->extractColor($asset);

            $asset->getContent()->setAttribute($colorFieldHandle, $color);
            $success = craft()->assets->storeFile($asset);
        }

        return $color;
    }
}
