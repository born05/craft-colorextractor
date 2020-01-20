<?php

namespace born05\colorextractor\console\controllers;

use born05\colorextractor\ColorExtractor;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Extracts colors from images.
 */
class DefaultController extends Controller
{
    /**
     * Exteracts colors from all images where missing.
     */
    public function actionIndex()
    {
        echo "Extract image colors.\n";
        
        ColorExtractor::$plugin->assetUpload->processImages();

        return "Done extracting image colors.";
    }
}
