<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Course;
use App\Models\Point;
use App\Models\Report;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class DashboardController extends Controller
{
    // Funcion para mostrar el dashboard
    public function index(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if ($user && $user->roles->contains('name', 'admin') || ($user && $user->roles->contains('name', 'editor')) || ($user && $user->roles->contains('name', 'collaborator'))) {
            // Si el usuario es administrador, mostrar el panel de administrador

            // Obtener los datos de la base de datos
            $requests = ModelsRequest::count();
            $completed = ModelsRequest::where('completed', 1)->count();
            $users = User::count();
            $courses = Course::where('revision_status', 'approved')->count();
            $lastRequests = ModelsRequest::latest()->take(7)->get();
            $lastUsers = User::latest()->take(12)->get();

            // Transformar los datos para que se puedan usar en la vista de forma mas sencilla
            $lastReports = Report::latest()->take(3)->get();
            $transformedReports = $lastReports->map(function ($report) {
                $data = null;
                // Verificar si el reporte es de un comentario o de una respuesta
                if ($report->comment_id) {
                    $commentModel = Comment::find($report->comment_id);
                    $data = [
                        'id' => $report->comment_id,
                        'type' => 'comment',
                        'comment' => $commentModel ? $commentModel->comment : null,
                    ];
                } elseif ($report->reply_id) {
                    $replyModel = CommentReply::find($report->reply_id);
                    $data = [
                        'id' => $report->reply_id,
                        'type' => 'reply',
                        'comment' => $replyModel ? $replyModel->comment : null,
                    ];
                }
                // Crear un array con los datos del reporte
                return [
                    'id' => $report->id,
                    'data' => $data,
                    'reason' => $report->reason,
                ];
            });

            $lastPending = Course::latest()
                ->whereNotNull('uploader')
                ->take(3)
                ->get();

            return Inertia::render('AdminPanel/Index', [
                'requestsCount' => $requests,
                'completedCount' =>  $completed,
                'usersCount' => $users,
                'coursesCount' => $courses,
                'lastRequests' => $lastRequests,
                'lastUsers' => $lastUsers,
                'lastReports' => $transformedReports,
                'lastPending' => $lastPending,
            ]);
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar el panel de cursos
    public function courses(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if ($user && $user->roles->contains('name', 'admin') || ($user && $user->roles->contains('name', 'editor')) || ($user && $user->roles->contains('name', 'collaborator'))) {
            // Si el usuario es administrador, mostrar el panel de administrador
            return Inertia::render('AdminPanel/Courses');
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar el panel de cursos pendientes
    public function pendingCourses(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if ($user && $user->roles->contains('name', 'admin') || ($user && $user->roles->contains('name', 'editor')) || ($user && $user->roles->contains('name', 'collaborator'))) {
            // Si el usuario es administrador, mostrar el panel de administrador
            return Inertia::render('AdminPanel/PendingCourses');
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar como se veria un curso de un 'uploader'
    public function preview($id, Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if ($user && $user->roles->contains('name', 'admin') || ($user && $user->roles->contains('name', 'editor')) || ($user && $user->roles->contains('name', 'collaborator'))) {
            $course =  Course::findOrFail($id);
            $lessons = $course->lessons()->with('points')->get();
            $points = Point::whereIn('lesson_id', $lessons->pluck('id'))->get();

            if($user && $user->roles->contains('name', 'collaborator')){
                if($user->id == $course->uploader){
                    return Inertia::render('AdminPanel/View', [
                        'phpVersion' => PHP_VERSION,
                        'course' => $course,
                        'lessons' => $lessons,
                        'points' => $points
                    ]);
                }else{
                    abort(403, 'Unauthorized');
                }
            }

            // Si el usuario es administrador, mostrar el panel de administrador
            return Inertia::render('AdminPanel/View', [
                'phpVersion' => PHP_VERSION,
                'course' => $course,
                'lessons' => $lessons,
                'points' => $points
            ]);
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar la vista de edicion de un curso
    public function editCourse(Request $request, $id)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if ($user && $user->roles->contains('name', 'admin') || ($user && $user->roles->contains('name', 'editor')) || ($user && $user->roles->contains('name', 'collaborator'))) {
            // Si el usuario es administrador, mostrar el panel de administrador
            $course =  Course::findOrFail($id);
            $lessons = $course->lessons()->with('points')->get();
            $points = Point::whereIn('lesson_id', $lessons->pluck('id'))->get();

            if($user && $user->roles->contains('name', 'collaborator')){
                if($user->id == $course->uploader){
                    return Inertia::render('AdminPanel/Lessons', [
                        'phpVersion' => PHP_VERSION,
                        'course' => $course,
                        'lessons' => $lessons,
                        'points' => $points
                    ]);
                }else{
                    abort(403, 'Unauthorized');
                }
            }
            
            return Inertia::render('AdminPanel/Lessons', [
                'phpVersion' => PHP_VERSION,
                'course' => $course,
                'lessons' => $lessons,
                'points' => $points
            ]);
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar el panel de requests
    public function requests(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if (($user && $user->roles->contains('name', 'admin')) || ($user && $user->roles->contains('name', 'editor')) || ($user && $user->roles->contains('name', 'collaborator'))) {
            // Si el usuario es administrador, mostrar el panel de administrador

            return Inertia::render('AdminPanel/Requests');
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar el panel de reports
    public function reports(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if (($user && $user->roles->contains('name', 'admin'))) {
            // Si el usuario es administrador, mostrar el panel de administrador

            return Inertia::render('AdminPanel/Reports');
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    // Funcion para mostrar el panel de users
    public function users(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol de administrador
        if ($user && $user->roles->contains('name', 'admin')) {
            // Si el usuario es administrador, mostrar el panel de administrador
            return Inertia::render('AdminPanel/Users');
        } else {
            // Si el usuario no es administrador, redirigir a una página de acceso no autorizado
            abort(403, 'Unauthorized');
        }
    }

    public function upload(Request $request)
    {
        $course_id = null;
        $yes = false;
        // Recogemos cuantos cursos ha subido el usuario ($id) y estan aprobados
        $count = Course::where('uploader', $request->user()->id)->where('revision_status', 'approved')->count();

        // Recogemos si el 'uploader' (usuario) tiene algun curso subido y esta pendiente
        $pendingCourse = Course::where('uploader', $request->user()->id)
            ->where('revision_status', 'pending')
            ->first();

        // Si existe se recoge la id del curso y cambiamos el boolean a true
        if ($pendingCourse) {
            $course_id =  $pendingCourse->id;
            $yes = true;
        } else {
            // Si no existe se crea un curso nuevo para que pueda editarlo
            $newcourse = new Course();
            $newcourse->name = 'My first Course';
            $newcourse->description = 'This is my first Course, you can edit me!';
            $newcourse->vision = false;
            $newcourse->img = null;
            $newcourse->uploader = $request->user()->id;
            $newcourse->revision_status = 'pending';
            $newcourse->save();
            $course_id = $newcourse->id;
        }

        // Recogemos los datos del curso que se esta editando
        $course =  Course::findOrFail($course_id);
        $lessons = $course->lessons()->with('points')->get();
        $points = Point::whereIn('lesson_id', $lessons->pluck('id'))->get();

        // Pasar el curso a la vista
        return Inertia::render('AdminPanel/UploadAP', [
            'course' => $course,
            'lessons' => $lessons,
            'points' => $points,
            'pending' => $yes,
            'count' => $count
        ]);
    }

    // Funcion para recoger los datos de los cursos en un json
    public function dataCourses(Request $request)
    {
        $name = '';
        $courseCriteria = [];
        $collaboratorID = $request->input('collaboratorId', null);

        // Si el usuario ha enviado una búsqueda, agregarla a la consulta
        if ($request->has("searchTerm")) {
            // Convertir la búsqueda en minúsculas y eliminar espacios en blanco al inicio y al final
            $name = strtolower(trim($request->input('searchTerm')));
            // Agregarlo al criterio
            $courseCriteria['name'] = '%' . $name . '%';
        }

        // Creamos una consulta de cursos
        $query = Course::query();

        // Aplicar los criterios de búsqueda
        foreach ($courseCriteria as $column => $value) {
            // Si el valor es una cadena y contiene el símbolo de porcentaje,
            // aplicar una consulta de búsqueda de texto completo (LIKE)
            if (is_string($value) && strpos($value, '%') !== false) {
                // Buscar los cursos aprobados que coincidan con el nombre
                $query->where($column, 'like', $value);
            } else {
                $query->where($column, $value);
            }
        }
        // Buscar solo los cursos aprobados
        $query->where('revision_status', 'approved');

        if ($collaboratorID !== null) {
            $query->where('uploader', $collaboratorID);
        }

        // Ordenar los cursos aprobados por visibilidad y recogerlos
        $courses = $query->orderBy('vision')->get();

        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function dataUsers(Request $request)
    {
        $name = '';
        $userCriteria = [];

        // Si el usuario ha enviado una búsqueda, agregarla a la consulta
        if ($request->has("searchTerm")) {
            // Convertir la búsqueda en minúsculas 
            //y eliminar espacios en blanco al inicio y al final
            $name = strtolower(trim($request->input('searchTerm')));
            // Agregarlo al criterio
            $courseCriteria['name'] = '%' . $name . '%';
        }

        // Creamos una consulta de usuarios
        $query = User::query();
        $query->with('roles');

        // Aplicar los criterios de búsqueda
        foreach ($userCriteria as $column => $value) {
            // Si el valor es una cadena y contiene el símbolo de porcentaje,
            // aplicar una consulta de búsqueda de texto completo (LIKE)
            if (is_string($value) && strpos($value, '%') !== false) {
                // Buscar los cursos aprobados que coincidan con el nombre
                $query->where($column, 'like', $value);
            } else {
                $query->where($column, $value);
            }
        }

        // Recoger toda la consulta en $users
        $users = $query->get();

        return response()->json([
            'users' => $users,
        ]);
    }

    public function dataRequests(Request $request)
    {
        $title = '';
        $requestCriteria = [];
        $completed = $request->input('completed', false);


        // Si el usuario ha enviado una búsqueda, agregarla a la consulta
        if ($request->has("searchTerm")) {
            // Convertir la búsqueda en minúsculas 
            //y eliminar espacios en blanco al inicio y al final
            $title = strtolower(trim($request->input('searchTerm')));
            // Agregarlo al criterio
            $requestCriteria['title'] = '%' . $title . '%';
        }

        // Creamos una consulta de las requests
        $query = ModelsRequest::query();
        // Aplicar los criterios de búsqueda
        foreach ($requestCriteria as $column => $value) {
            // Si el valor es una cadena y contiene el símbolo de porcentaje,
            // aplicar una consulta de búsqueda de texto completo (LIKE)
            if (is_string($value) && strpos($value, '%') !== false) {
                $query->where($column, 'like', $value);
            } else {
                $query->where($column, $value);
            }
        }

        if ($completed) {
            $requests = ModelsRequest::where('completed', 0)->get();
        }else{
            // Recoger las requests ordenadas por fecha de creación y por si están completadas o no
            $requests = $query->orderBy('completed')->orderByDesc('created_at')->get();
        }



        return response()->json([
            'requests' => $requests,
        ]);
    }

    public function dataReports(Request $request)
    {
        $comment = '';

        // Si el usuario ha enviado una búsqueda, guardarla en una variable
        if ($request->has("searchTerm")) {
            // Convertir la búsqueda en minúsculas y eliminar espacios en blanco al inicio y al final
            $comment = strtolower(trim($request->input('searchTerm')));
        }

        // Crear consulta de Reportes
        $query = Report::query();
        // Recoger los reportes
        $reports = $query->get();

        // Transformar los datos para que se puedan usar en la vista de forma mas sencilla
        $transformedReports = $reports->map(function ($report) {
            $data = null;
            // Verificar si el reporte es de un comentario o de una respuesta
            if ($report->comment_id) {
                $commentModel = Comment::find($report->comment_id);
                $data = [
                    'id' => $report->comment_id,
                    'type' => 'comment',
                    'comment' => $commentModel ? $commentModel->comment : null,
                ];
            } elseif ($report->reply_id) {
                $replyModel = CommentReply::find($report->reply_id);
                $data = [
                    'id' => $report->reply_id,
                    'type' => 'reply',
                    'comment' => $replyModel ? $replyModel->comment : null,
                ];
            }
            // Crear un array con los datos del reporte
            return [
                'id' => $report->id,
                'data' => $data,
                'reason' => $report->reason,
            ];
        });

        // Hacer la búsqueda por comentario dentro del array de reportes (al contrario de las otras funciones que son a nivel de peticion a base de datos)
        if ($comment) {
            $transformedReports = $transformedReports->filter(function ($transformedReport) use ($comment) {
                return stripos($transformedReport['data']['comment'], $comment) !== false;
            });
        }

        // Devolver los reportes transformados
        return response()->json([
            'reports' => $transformedReports,
        ]);
    }

    public function dataPendingCourses(Request $request)
    {
        $name = '';
        $courseCriteria = [];
        $collaboratorID = $request->input('collaboratorId', null);

        // Si el usuario ha enviado una búsqueda, agregarla a la consulta
        if ($request->has("searchTerm")) {
            // Convertir la búsqueda en minúsculas y eliminar espacios en blanco al inicio y al final
            $name = strtolower(trim($request->input('searchTerm')));
            // Agregarlo al criterio
            $courseCriteria['name'] = '%' . $name . '%';
        }

        // Crear una consulta de cursos
        $query = Course::query();

        // Aplicar los criterios de búsqueda 
        foreach ($courseCriteria as $column => $value) {
            // Si el valor es una cadena y contiene el símbolo de porcentaje,
            // aplicar una consulta de búsqueda de texto completo (LIKE)
            if (is_string($value) && strpos($value, '%') !== false) {
                $query->where($column, 'like', $value);
            } else {
                $query->where($column, $value);
            }
        }

        // Agregar condición para obtener cursos con un uploader
        $query->whereNotNull('uploader');

        if ($collaboratorID !== null) {
            $query->where('uploader', $collaboratorID);
        }

        // Recoger todos los cursos ordenados por visibilidad
        $courses = $query->orderBy('vision')->get();

        return response()->json([
            'courses' => $courses,
        ]);
    }
}
