<?php

namespace App\Services\CallDataProcessor;

/**
 * Process an audio channel from a call.
 */
class ChannelDataProcessor
{
	protected $channelVectors;
	protected $invertedChannelVectors;

	function __construct($channel)
	{
		$this->extractChannelVectors($channel);
		$this->invertVectorData();
	}

	/**
	 * Return channel vectors
	 */
	public function getChannelVectors()
	{
		return $this->channelVectors;
	}

	/**
	 * Return inverted channel vectors
	 */
	public function getInvertedChannelVectors()
	{
		return $this->invertedChannelVectors;
	}

	/**
     * Extract time intervals from file data.
     */
    protected function extractChannelVectors(string $data)
    {
        $fileLines = preg_split('/\r\n/', trim($data));
        $soundDataVectors = [];
        $currentDataVector = [];

        /**
         * Fill the soundDataVector with all silence interval pairs.
         */
        foreach ($fileLines as $index => $line) {
            // Get only the silence start/end seconds from the line
            preg_match('/: (0|[1-9]\d*)?(\.\d+)?/', $line, $dataPoint);
            $dataPoint = substr($dataPoint[0], 2);

            // Store data point appropriately for current vector
            if ($index %2 == 0) {
                $currentDataVector[0] = $dataPoint;
            }else{
                $currentDataVector[1] = $dataPoint;
                $soundDataVectors[] = $currentDataVector;
            }
        }

        $this->channelVectors = $soundDataVectors;
    }

    /**
     * Take the time intervals from the vectors and invert them.
     */
    protected function invertVectorData(): void
    {
        $invertedDataVectors = [];
        $currentDataVector = [];
        $vectorsCount = count($invertedDataVectors);

        foreach ($this->channelVectors as $index => &$vector) {
            // Invert first vector
            if ($index == 0) {
                $currentDataVector[0] = 0;
                $currentDataVector[1] = $vector[0];
                $invertedDataVectors[] = $currentDataVector;
                continue;
            }
            
            // Invert other vectors
            $currentDataVector[0] = $this->channelVectors[$index - 1][1];
            $currentDataVector[1] = $vector[0];
            $invertedDataVectors[] = $currentDataVector;
        }
        
        $this->invertedChannelVectors = $invertedDataVectors;
    }

    /**
     * Get the longest time interval in the collection of vectors
     */
    public function getLongestInterval($fromInvertedVectors = true)
    {
    	$vectors = ($fromInvertedVectors ? $this->invertedChannelVectors : $this->channelVectors);
        $longestInterval = 0;

        foreach ($vectors as &$vector) {
            $interval = $vector[1] - $vector[0];
            if ($longestInterval < $interval) {
                $longestInterval = $interval;
            }
        }

        return round($longestInterval, 2);
    }

    /**
     * Sum all vector intervals and return the total time from them.
     */
    public function calcVectorsTotalTime($fromInvertedVectors = true)
    {
    	$vectors = ($fromInvertedVectors ? $this->invertedChannelVectors : $this->channelVectors);
        $totalTime = 0;

        foreach ($vectors as $vector) {
            $totalTime += ($vector[1] - $vector[0]);
        }

        return round($totalTime, 2);
    }
}