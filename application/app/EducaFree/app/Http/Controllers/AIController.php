<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class AIController extends Controller
{
    // Funcion para la respuesta de la Inteligencia Artificial
    public function request(Request $request)
    {
        // Recojemos el mensaje 'prompt' que nos manda el usuario
        $prompt = $request->input('prompt');
        
        try {
            // Llamamos a la IA
            $response = OpenAI::completions()->create([
                'model' => 'gpt-3.5-turbo',
                'prompt' => $prompt,
                'max_tokens' => 150,
            ]);

            // Recogemos la respuesta que nos da
            $aiResponse = $response->choices[0]->text;

            // La devolvemos en formato JSON
            return response()->json(['response' => $aiResponse, 'type' => 'ok', 'AI' => 'true']);
        } catch (\OpenAI\Exceptions\ErrorException $e) {

            if ($e->getMessage() === 'You exceeded your current quota, please check your plan and billing details. For more information on this error, read the docs: https://platform.openai.com/docs/guides/error-codes/api-errors.') {
                // Si esta la cuota completa nos da error
                return response()->json(['response' => 'The current Quota is exceeded.', 'type' => 'error', 'AI' => 'true'], 200);
            } else {

                return response()->json(['response' => 'An OpenAI API error occurred: ' . $e->getMessage() , 'type' => 'error', 'AI' => 'true'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing the request: ' . $e->getMessage()], 500);
        }
    }
}
