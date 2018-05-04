<?php
/**
 * Colorextractor Command
 *
 * ./craft/app/etc/console/yiic colorextractor
 */

namespace Craft;

class ColorextractorCommand extends BaseCommand
{
    public function actionIndex()
    {
        craft()->colorExtractor_assetUpload->processImages();
    }
}
