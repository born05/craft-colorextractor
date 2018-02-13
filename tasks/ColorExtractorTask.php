<?php
namespace Craft;

/**
 * Power Nap task
 */
class ColorExtractorTask extends BaseTask
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
            'assetIds' => AttributeType::Mixed,
        ];
    }

    /**
     * Returns the default description for this task.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Extract color from assets';
    }

    /**
     * Gets the total number of steps for this task.
     *
     * @return int
     */
    public function getTotalSteps()
    {
        return count($this->getSettings()->assetIds);
    }

    /**
     * Runs a task step.
     *
     * @param int $step
     * @return bool
     */
    public function runStep($step)
    {
        $assetIds = $this->getSettings()->assetIds;

        if (isset($assetIds[$step - 1])) {
            return $this->runSubTask('ColorExtractor_Extact', null, [
                'assetId' => $assetIds[$step - 1],
            ]);
        }

        return true;
    }
}