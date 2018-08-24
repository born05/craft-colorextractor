<?php

namespace born05\colorextractor\console\controllers;

use born05\colorextractor\ColorExtractor;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Default Command
 * 
 * ./craft color-extractor/default
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        echo "Extract image colors.\n";
        
        ColorExtractor::$plugin->assetUpload->processImages();

        return "Done extracting image colors.";
    }
}
