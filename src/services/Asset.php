<?php

namespace born05\colorextractor\services;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

use Craft;
use craft\base\Component;
use craft\elements\Asset as AssetElement;
use yii\base\Exception;

class Asset extends Component
{
    /**
     * Extract colors from asset image.
     * @param  AssetFileModel $asset
     * @return string
     */
    public function extractColor(AssetElement $asset)
    {
        // Only image support, but no svg.
        if ($asset->kind !== AssetElement::KIND_IMAGE || $asset->mimeType === 'image/svg+xml') {
            return null;
        }

        // The volume needs urls
        if (empty($asset->url)) {
            throw new Exception('The volume has no urls.');
        }
        $palette = Palette::fromFilename($asset->url);

        // No colors found.
        if ($palette->count() < 1) {
            return null;
        }

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
    public function getImageColor(AssetElement $asset, $forceSave = false)
    {
        $color = isset($asset->imageColor) ? $asset->imageColor : null;

        // Only Extract color when forced.
        if ($forceSave && $asset->canGetProperty('imageColor')) {
            try {
                $color = $this->extractColor($asset);
            } catch (Exception $e) {
                Craft::error(
                    $e->getMessage(),
                    __METHOD__
                );
            }

            if (!empty($color)) {
                $asset->setFieldValue('imageColor', $color);
                Craft::$app->getElements()->saveElement($asset);
            }
        }

        // Return color with black fallback.
        return empty($color) ? '#000000' : $color;
    }
}
