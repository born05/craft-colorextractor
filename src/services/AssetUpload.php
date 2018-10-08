<?php

namespace born05\colorextractor\services;

use born05\colorextractor\jobs\ColorExtractorTask as ColorExtractorTaskJob;

use Craft;
use craft\base\Component;
use craft\elements\Asset;

class AssetUpload extends Component
{
    public function onReplaceFile(Asset $asset)
    {
        if ($asset->kind === 'image' && $asset->mimeType !== 'image/svg+xml') {
            $this->createTask($asset->id);
        }
    }

    public function onSaveAsset(Asset $asset)
    {
        if ($asset->kind === 'image' && $asset->mimeType !== 'image/svg+xml') {
            $this->createTask($asset->id);
        }
    }

    /**
     * Handles initial install
     */
    public function processImages()
    {
        if (Asset::find()->kind(Asset::KIND_IMAGE)->canGetProperty('imageColor')) {
            $assetIds = Asset::find()
              ->kind(Asset::KIND_IMAGE)
              ->imageColor(':empty:')
              ->limit(null)
              ->ids();

            $this->createTask($assetIds);
        }
    }
    
    /**
     * Create task
     * @param  string|array $assetIds
     */
    private function createTask($assetIds)
    {
        if (!is_array($assetIds)) {
            $assetIds = [$assetIds];
        }
        
        $queue = Craft::$app->getQueue();

        $jobId = $queue->push(new ColorExtractorTaskJob([
            'assetIds' => $assetIds,
        ]));
    }
}
