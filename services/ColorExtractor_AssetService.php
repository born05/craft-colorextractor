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
        // No svg support.
        if ($asset->mimeType === 'image/svg+xml') {
            return null;
        }

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
    public function getImageColor(AssetFileModel $asset, $forceSave = false)
    {
        $color = isset($asset->imageColor) ? $asset->imageColor : null;

        // Only Extract color when forced.
        if ($forceSave) {
            try {
                $color = $this->extractColor($asset);
            } catch (Exception $e) {
                ColorExtractorPlugin::log($e->getMessage(), LogLevel::Error, true);
                return false;
            }

            $asset->getContent()->setAttribute('imageColor', $color);
            $success = craft()->assets->storeFile($asset);
        }

        // Return color with black fallback.
        return empty($color) ? '#000000' : $color;
    }
}
