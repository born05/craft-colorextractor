<?php
namespace Craft;

class ColorExtractor_AssetUploadService extends BaseApplicationComponent
{
    public function onReplaceFile(Event $event)
    {
        $asset = $event->params['asset'];
        
        if ($asset->kind === 'image') {
            craft()->colorExtractor_asset->getImageColor($asset, true);
        }

        return $event;
    }

    public function onSaveAsset(Event $event)
    {
        if ($event->params['isNewAsset']) {
            $asset = $event->params['asset'];
            
            if ($asset->kind === 'image') {
                craft()->colorExtractor_asset->getImageColor($asset, true);
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
        $criteria->limit = null;
        $assetIds = $criteria->ids();

        craft()->tasks->createTask('ColorExtractor', '', array(
            'assetIds' => $assetIds
        ));
    }
}
