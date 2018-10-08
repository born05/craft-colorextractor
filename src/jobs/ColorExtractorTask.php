<?php

namespace born05\colorextractor\jobs;

use born05\colorextractor\ColorExtractor;

use Craft;
use craft\elements\Asset;
use craft\queue\BaseJob;
use yii\base\Exception;

/**
 * Color Extractor task
 *
 * use born05\colorextractor\jobs\ColorExtractorTask as ColorExtractorTaskJob;
 *
 * $queue = Craft::$app->getQueue();
 * $jobId = $queue->push(new ColorExtractorTaskJob([
 *     'assetIds' => [],
 * ]));
 */
class ColorExtractorTask extends BaseJob
{
    public $assetIds = [];

    public function execute($queue)
    {
        if (!Asset::find()->kind(Asset::KIND_IMAGE)->canGetProperty('imageColor')) {
            throw new Exception('Assets of kind image are missing an "imageColor" field.');
        }

        $assets = Asset::find()
          ->id($this->assetIds)
          ->kind(Asset::KIND_IMAGE)
          ->imageColor(':empty:')
          ->limit(null)
          ->all();

        $totalSteps = count($assets);
        $step = 0;
        foreach ($assets as $asset) {
            $step++;
            $this->setProgress($queue, $step / $totalSteps);
            ColorExtractor::$plugin->asset->getImageColor($asset, true);
        }
    }

    protected function defaultDescription(): string
    {
        return Craft::t('color-extractor', 'ColorExtractorTask');
    }
}
