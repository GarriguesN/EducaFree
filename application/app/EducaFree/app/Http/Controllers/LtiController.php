<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use LonghornOpen\LaravelCelticLTI\LtiTool;

class LtiController extends Controller
{

    // Funcion para lanzar la aplicacion web al LMS
    public function launch(Request $request)
    {
         // Obtener el valor de la variable LTI_MESSAGE_HINT
         $lti_message_hint = $request->input('lti_message_hint');
         $lti_message_hint_data = json_decode($lti_message_hint, true);
 
         // Obtener el valor de la variable CMID
         if ($lti_message_hint_data && isset($lti_message_hint_data['cmid'])) {
             $cmid = $lti_message_hint_data['cmid'];
         } else {
             return response()->json('CMID fail');
         }
 
 
         $iss = $request->input('iss');
         
 
         // Construir la URL para la solicitud al servicio web del LMS (Moodle en este caso)
         $baseURL = "{$iss}/webservice/rest/server.php";

         $params = [
             'wstoken' => 'e19f899a851fd8d85caa35c0bf33fc49',
             'moodlewsrestformat' => 'json',
             'wsfunction' => 'core_course_get_course_module',
             'cmid' => $cmid
         ];

         $response = Http::get($baseURL, $params)->throw();
 
         $responseData = json_decode($response->body(), true);
 
         // Verificar si la solicitud fue exitosa
         if ($response->successful()) {
             // Renderizar la vista Inertia con los datos obtenidos segun el curso seleccionado
             // segun su ID, en esta caso solo hay 2 (2, 3)
             if ($responseData['cm']['course'] == 2) {
                 $courses = Course::where('name', 'LIKE', '%minus%')
                 ->withCount('lessons')->get();
                 return Inertia::render('Lti/Index', [
                     'cmid' => $cmid,
                     'responseData' => $responseData,
                     'courses' => $courses
                 ]);
             } else if ($responseData['cm']['course'] == 3) {
                 $courses = Course::where('name', 'LIKE', '%tempore%')
                 ->withCount('lessons')->get();
                 return Inertia::render('Lti/Index', [
                     'cmid' => $cmid,
                     'responseData' => $responseData,
                     'courses' => $courses
                 ]);
             }
         } else {
             // Manejar errores de la solicitud
             return response()->json('Error');
         }
     }

    // Funcion para obtener el JWK
    public function getJWKS()
    {
        $tool = LtiTool::getLtiTool();
        return $tool->getJWKS();
    }

    // Funcion para comprobar que la comunicacion (handshake) es funcional 
    public function ltiMessage(Request $request)
    {
        $tool = LtiTool::getLtiTool();

        $tool->handleRequest();


        if ($tool->getLaunchType() === $tool::LAUNCH_TYPE_LAUNCH) {

            dd($request->all());

            $idCourse = json_decode($request->lti_message_hint)->cmid;

            dd($idCourse);
        }

        die("Unknown message type");
    }
}
