<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calls\ProcessDataRequest;
use App\Services\CallDataProcessor\ChannelDataProcessor;

class CallController extends Controller
{
    /**
     * Process two audio channels and return call metrics
     * 
     * @param App\Http\Requests\Calls\ProcessDataRequest $request
     * @return \Illuminate\Http\Response
     */
    public function processCallData(ProcessDataRequest $request)
    {
        // Process user channel
        $userChannel = $request->user_channel
            ->path();
        $userChannel = file_get_contents($userChannel);
        $userChannel = new ChannelDataProcessor($userChannel);

        // Process customer channel
        $customerChannel = $request->customer_channel
            ->path();
        $customerChannel = file_get_contents($customerChannel);
        $customerChannel = new ChannelDataProcessor($customerChannel);

        // Calc user talk percentage
        $userTalkTime = $userChannel->calcVectorsTotalTime();
        $userTalkPercentage = $userTalkTime / ($userTalkTime + $customerChannel->calcVectorsTotalTime()) * 100;

        // Build response object
        $responseObject = new \stdClass();

        $responseObject-> longest_user_monologue = $userChannel->getLongestInterval();
        $responseObject-> longest_customer_monologue = $customerChannel->getLongestInterval();
        
        $responseObject-> user_talk_percentage = round($userTalkPercentage, 2);
        
        $responseObject-> user = $userChannel->getInvertedChannelVectors();
        $responseObject-> customer = $customerChannel->getInvertedChannelVectors();
        
        $responseObject = json_encode($responseObject);

        return response($responseObject, 200);
    }
}
