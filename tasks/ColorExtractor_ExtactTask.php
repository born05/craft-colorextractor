<?php
namespace Craft;

/**
 * Power Nap task
 */
class ColorExtractor_ExtactTask extends BaseTask
{
    /**
     * Defines the settings.
     *
     * @access protected
     * @return array
     */
    protected function defineSettings()
    {
        return [
            'assetId' => AttributeType::Number,
        ];
    }
    
    /**
     * Returns the default description for this task.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Extract color from asset';
    }

    /**
     * Gets the total number of steps for this task.
     *
     * @return int
     */
    public function getTotalSteps()
    {
        return 1;
    }

    /**
     * Runs a task step.
     *
     * @param int $step
     * @return bool
     */
    public function runStep($step)
    {
        $criteria = craft()->elements->getCriteria(ElementType::Asset);
        $criteria->id = $this->getSettings()->assetId;
        $criteria->kind = 'image';
        $assetModel = $criteria->first();

        if (isset($assetModel)) {
            craft()->colorExtractor_asset->getImageColor($assetModel, 'imageColor', true);
        }

        return true;
    }
}