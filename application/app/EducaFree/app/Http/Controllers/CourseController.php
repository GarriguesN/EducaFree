<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Comment;
use App\Models\Course;
use App\Models\CourseInfo;
use App\Models\Favorite;
use App\Models\Point;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class CourseController extends Controller
{
    //Funcion para mostrar los cursos
    public function show($id, Request $request)
{
    //Recoge el usuario autenticado
    $user = $request->user();

    //Recoge los parametros de la ruta 
    //y comprueba si existe 'cmid' para poder mostrar el curso 
    //segun desde donde se accede desde la LMS
    $routeParams = Route::current()->parameters();
    $cmid = $routeParams['cmid'] ?? null;

    //Si existe el parametro cmid, se busca el curso en la base de datos y se muestra
    $course = Course::findOrFail($id);
    $lessons = $course->lessons()->with('points')->get(); 
    $points = Point::whereIn('lesson_id', $lessons->pluck('id'))->get(); 

    // Caso 1: Usuario autenticado
    if ($user !== null) {

        //Comprueba si el usuario ya ha accedido al curso
        $courseInfo = CourseInfo::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->first();

        //Si no ha accedido al curso, se crea un registro en la tabla CourseInfo
        if (!$courseInfo) {
            $courseInfo = new CourseInfo();
            $courseInfo->user_id = $user->id;
            $courseInfo->course_id = $course->id;
            $courseInfo->progress = 0;
            $courseInfo->save();
        }

        //Si el usuario haya o no accedido al curso, se muestra la vista
        return Inertia::render('Courses/Course', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'course' => $course,
            'lessons' => $lessons,
            'points' => $points,
        ]);
    }
        // Caso 2: Datos de la solicitud presentes
        elseif ($cmid !== null) {
            // Si se encuentra cmid se muestran los cursos especificos
            return Inertia::render('Courses/Course', [
                'course' => $course,
                'lessons' => $lessons,
                'points' => $points
            ]);
        }
        // Caso 3: Usuario no autenticado
        else {
            return redirect('/login');
        }
    }

    //Funcion para eliminar un curso ($id)
    public function delete($id){
            Course::where('id', $id)->delete();
            return Inertia::location(route('dashboard.courses'));
    }


    //Funcion para agregar un curso
    public function addCourse(CourseRequest $request){
        $course = new Course();
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $img = $request->file('img');

        // Si se sube una imagen, se guarda en la carpeta de imagenes y se guarda la ruta en la base de datos
        if(isset($img)) {
            $imgName = str_replace(' ', '', $request->input('name'));
            $img->storeAs('public/ImagesCourses', $imgName. '.png');
            $course->img = $imgName.'.png';
        }

        $course->save();
        return Inertia::location(route('dashboard.courses'));
    }

    //Funcion para editar un curso
    public function editCourse(CourseRequest $request, $id) {
        // Se busca el curso por el id y se actualizan los datos
        $course = Course::findOrFail($id);
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $img = $request->file('img');

        // Si se sube una imagen, se guarda en la carpeta de imagenes y se guarda la ruta en la base de datos
        if(isset($img)) {
            $imgName = str_replace(' ', '', $request->input('name'));
            $img->storeAs('public/ImagesCourses', $imgName. '.png');
            $course->img = $imgName.'.png';
        }else{
            if(isNull($img) && $request->input('edited') == true){
                $course->img = null;
            }
        }
        $course->save();

        // Se redirecciona a la vista de cursos, depende si el curso esta siendo editado por un 'uploader' (usuario) o editado por el admin o editor
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }else{
            return redirect()->route('dashboard.course', $id); 
        }
        
    }

    // Funcion para hacer visible un curso
    public function visionOn($id){
        Course::where('id', $id)->update(['vision' => 1]);
        return Inertia::location(route('dashboard.courses'));
    }

    // Funcion para hacer invisible un curso
    public function visionOff($id){
        Course::where('id', $id)->update(['vision' => 0]);
        return Inertia::location(route('dashboard.courses'));
    }

    // Funcion para exportar un curso como PDF
    public function exportPdf($id){
        // $course = Course::with('lessons.points')->findOrFail($id);
        
        // // Se carga la vista del PDF desde la carpeta 'PDFs' y se le pasa la vista 'course', que es un blade.php con estilos y contenido
        // $pdf = Pdf::loadView('PDFs.course', compact('course'));
        
        // // Se descarga el PDF con el id
        // return $pdf->download("Curso_".$id.".pdf");
        // Obten el curso con las lecciones y los puntos asociados
        $course = Course::with('lessons.points')->findOrFail($id);
        
        // Carga la vista del PDF como una cadena de HTML
        $html = view('PDFs.course', compact('course'))->render();
        
        // Reemplaza las URLs de las imágenes con sus equivalentes en base64 en el contenido HTML
        $html = preg_replace_callback('/<img(?![^>]*class="header-logo")[^>]+src="([^">]+)".*?>/i', function($match) {
            // Devuelve el mensaje de error con estilos CSS en línea
            return '<div style="font-style: italic; color: #666; font-size: 10px; padding: 3px; text-align: center;">Image not available in PDF format, please refer to the website</div>';
        }, $html);

        // Genera el PDF con el contenido modificado
        $pdf = PDF::loadHTML($html);
        
        // Descarga el PDF con el id
        return $pdf->download("Curso_" . $id . ".pdf");
    }

    // Funcion para actualizar el progreso del curso segun el usuario
    public function updateInfo($id, Request $request){
        $user = $request->user();
        $progress = $request->input('progress');

        $courseInfo = CourseInfo::where('user_id', $user->id)
        ->where('course_id', $id)
        ->first();

        if ($courseInfo) {
            $courseInfo->progress = $progress;
            $courseInfo->save();
        }
    }

    //Funcion para añadir a favoritos un curso
    public function addFavorites($id, Request $request){
        $user = $request->user();

        $favorites = Favorite::where('user_id', $user->id)
        ->where('course_id', $id)
        ->first();

        if ($favorites) {
            $favorites->delete();
        }else{
            $favorite = new Favorite();
            $favorite->user_id = $user->id;
            $favorite->course_id = $id;
            $favorite->save();
        }

        return Inertia::location(route('courses'));
    }

    // Funcion para aceptar un curso subido por un uploader y que este pendiente de revision
    public function accept($id){
        $course = Course::findOrFail($id);
        $course->revision_status = 'approved';
        $uploader = $course->uploader; // Coger el id del usuario
        $user = User::where('id', $uploader)->first();

        if ($user && !$user->hasRole('colaborator')) {
            $user->assignRole('colaborator');
        }

        $course->save();
        return Inertia::location(route('dashboard.pendingCourses'));
    }

    // Funcion para recoger los cursos creados pendientes de revision
    public function dataPendings(Request $request)
    {

        $userId = $request->input('userId');
    

        if (!$userId) {
            return response()->json([
                'error' => 'User ID is required.'
            ], 400);
        }

        $pendingCourses = Course::where('uploader', $userId)
            ->where('revision_status', 'pending')
            ->first();
    

        return response()->json([
            'hasPendingCourses' => $pendingCourses,
        ]);
    }
}
