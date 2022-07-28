<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProcessCallTest extends TestCase
{
    /**
     * Test response of /api/process-call-data.
     *
     * @return void
     */
    public function test_process_call_data()
    {
        // Get test file for user
        $userChannelFile = new File(
            base_path().'/storage/app/testAssets/user-channel.txt'
        );

        // Get test file for customer
        $customerChannelFile = new File(
            base_path().'/storage/app/testAssets/customer-channel.txt'
        );

        // Build mock request
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])
        ->post('/api/process-call-data', [
            'user_channel' => $userChannelFile,
            'customer_channel' => $customerChannelFile
        ]);

        // Check response status
        $response->assertStatus(200);

        // Check response data
        $response->assertJson([
            'longest_user_monologue' => 322.35,
            'longest_customer_monologue' => 177.97,
            'user_talk_percentage' => 61.07,
        ]);
        $responseContent = json_decode($response->getContent());
        $this->assertTrue(is_array($responseContent->user));
        $this->assertTrue(is_array($responseContent->customer));

        // Check vector data 
        foreach ($responseContent->user as $vector) {
            $this->assertTrue(is_array($vector));
            $this->assertTrue(is_numeric($vector[0]));
            $this->assertTrue(is_numeric($vector[1]));
        }
    }
}
