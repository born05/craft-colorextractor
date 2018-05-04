<?php
namespace Craft;

class ColorExtractor_AssetUploadService extends BaseApplicationComponent
{
    public function onReplaceFile(Event $event)
    {
        $asset = $event->params['asset'];
        
        if ($asset->kind === 'image' && $asset->mimeType !== 'image/svg+xml') {
            $this->createTask($asset->id);
        }

        return $event;
    }

    public function onSaveAsset(Event $event)
    {
        if ($event->params['isNewAsset']) {
            $asset = $event->params['asset'];
            
            if ($asset->kind === 'image' && $asset->mimeType !== 'image/svg+xml') {
                $this->createTask($asset->id);
            }
        }

        return $event;
    }

    /**
     * Handles initial install
     */
    public function processImages()
    {
        $criteria = craft()->elements->getCriteria(ElementType::Asset);
        $criteria->kind = 'image';
        $criteria->imageColor = ':empty:';
        $criteria->limit = null;
        $assetIds = $criteria->ids();

        $this->createTask($assetIds);
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

        craft()->tasks->createTask('ColorExtractor', '', [
            'assetIds' => $assetIds,
        ]);
    }
}
