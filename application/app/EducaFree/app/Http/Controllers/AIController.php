<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class AIController extends Controller
{
    
    public function request(Request $request)
    {
        // Extract the prompt from the request
        $prompt = $request->input('prompt');
        
        try {
            // Call OpenAI's API using the OpenAI facade
            $response = OpenAI::completions()->create([
                'model' => 'gpt-3.5-turbo',
                'prompt' => $prompt,
                'max_tokens' => 150, // Adjust as needed
            ]);

            // Extract the AI's response from the API response
            $aiResponse = $response->choices[0]->text;

            // Return the AI's response as JSON
            return response()->json(['response' => $aiResponse, 'type' => 'ok', 'AI' => 'true']);
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            // Handle exceptions related to OpenAI's API
            if ($e->getMessage() === 'You exceeded your current quota, please check your plan and billing details. For more information on this error, read the docs: https://platform.openai.com/docs/guides/error-codes/api-errors.') {
                // Handle the quota exceeded exception
                return response()->json(['response' => 'The current Quota is exceeded.', 'type' => 'error', 'AI' => 'true'], 200);
            } else {
                // Return a generic error message for other OpenAI-related exceptions
                return response()->json(['response' => 'An OpenAI API error occurred: ' . $e->getMessage() , 'type' => 'error', 'AI' => 'true'], 200);
            }
        } catch (\Exception $e) {
            // Handle other exceptions (non-OpenAI related)
            return response()->json(['error' => 'An error occurred while processing the request: ' . $e->getMessage()], 500);
        }
    }
}
