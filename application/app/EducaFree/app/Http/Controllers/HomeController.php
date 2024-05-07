<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestRequest;
use App\Models\Course;
use App\Models\CourseInfo;
use App\Models\Favorite;
use App\Models\Point;
use App\Models\Request as MRequest;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


class HomeController extends Controller
{

    // Funcion para mostrar la vista de inicio
    public function home()
    {
        // Verificar si ya existe un curso aleatorio en caché
        $oneRandom = Cache::get('one_random');

        // Si no hay un curso aleatorio en caché, obtener un curso aleatorio de la base de datos
        if (!$oneRandom) {
            $oneRandom = Course::where('vision', 1)->withCount('lessons')->inRandomOrder()->take(1)->get();
            Cache::put('one_random', $oneRandom, 86400); // 86400 seg = 24 horas
        }

        // Verificar si ya existen cursos aleatorios en caché
        $randomCourses = Cache::get('random_courses');
        // Si no hay cursos aleatorios en caché, obtener 6 cursos aleatorios de la base de datos
        if (!$randomCourses) {
            $randomCourses = Course::where('vision', 1)->withCount('lessons')->inRandomOrder()->take(6)->get();

            // Almacenar los cursos aleatorios en caché durante 24 horas
            Cache::put('random_courses', $randomCourses, 86400); // 86400 seg = 24 horas
        }

        // Obtener el número total de cursos que son posibles ver cara al usuario
        $courses = Course::where('vision', 1)->count();

        // Mostrar la vista de inicio con los cursos aleatorios
        return Inertia::render('Home/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'courses' => $courses,
            'randomCourses' => $randomCourses,
            'oneRandom' => $oneRandom
        ]);
    }

    // Funcion para mostrar la vista de about
    public function about()
    {
        return Inertia::render('Home/About', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION
        ]);
    }

    // Funcion para mostrar la vista de privacy
    public function privacy()
    {
        return Inertia::render('Home/Privacy', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION
        ]);
    }

    // Funcion para mostrar la vista de conditions
    public function conditions()
    {
        return Inertia::render('Home/Conditions', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION
        ]);
    }

    // Funcion para mostrar la vista de courses
    public function courses(Request $request)
    {
        // Recogemos el id del usuario
        $user = $request->user();
        $id = $user->id;

        return Inertia::render('Home/Courses', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'userId' => $id
        ]);
    }

    // Funcion para mostrar la vista de upload
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
            // dd($request->all());
            if($request->has('title') && $request->has('description')){
                $newcourse = new Course();
                $newcourse->name = $request->title;
                $newcourse->description = $request->description;
                $newcourse->vision = false;
                $newcourse->img = null;
                $newcourse->uploader = $request->user()->id;
                $newcourse->revision_status = 'pending';
                $newcourse->save();
                $course_id = $newcourse->id;
            }else{
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
        }

        // Recogemos los datos del curso que se esta editando
        $course =  Course::findOrFail($course_id);
        $lessons = $course->lessons()->with('points')->get();
        $points = Point::whereIn('lesson_id', $lessons->pluck('id'))->get();

        // Pasar el curso a la vista
        return Inertia::render('Home/Upload', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'course' => $course,
            'lessons' => $lessons,
            'points' => $points,
            'pending' => $yes,
            'count' => $count
        ]);
    }

    public function deletePendingCourse(Request $request){

        $pendingCourse = Course::where('uploader', $request->user()->id)
            ->where('revision_status', 'pending')
            ->first();

        if($pendingCourse){
            $pendingCourse->delete();
        }

        return Inertia::location(route('home'));
    }

    public function deletePendingCourseNew(Request $request){
        $ok = false;
        $pendingCourse = Course::where('uploader', $request->user()->id)
            ->where('revision_status', 'pending')
            ->first();

        if($pendingCourse){
            $pendingCourse->delete();
            $ok = true;
        }

        return response()->json(['ok' => $ok], 200);
    }

    public function dataCourses(Request $request)
    {
        $name = '';
        $courseCriteria = [
            'vision' => 1, //El criterio solo permite cursos que sean visibles
        ];

        // Si el usuario ha enviado una búsqueda, agregarla a la consulta
        if ($request->has("searchTerm")) {
            // Convertir la búsqueda en minúsculas 
            //y eliminar espacios en blanco al inicio y al final
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
                $query->where($column, 'like', $value);
            } else {
                $query->where($column, $value);
            }
        }

        // Recoger los cursos con el contador de lecciones
        $courses = $query->withCount('lessons')->get();

        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function dataRandomCourses()
    {
        // Verificar si ya existen cursos aleatorios en caché
        $randomCourses = Cache::get('random_courses');
        // Si no hay cursos aleatorios en caché, obtener 6 cursos aleatorios de la base de datos
        if (!$randomCourses) {
            $randomCourses = Course::where('vision', 1)->withCount('lessons')->inRandomOrder()->take(6)->get();

            // Almacenar los cursos aleatorios en caché durante 24 horas
            Cache::put('random_courses', $randomCourses, 86400); // 86400 seg = 24 horas
            dump('new courses');
        }

        // Guardarlos en courses
        $courses = $randomCourses;

        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function dataCoursesInfo($id)
    {
        // Obtener la información del curso del usuario actual
        $courseInfo = CourseInfo::where('user_id', $id)->get();

        // Devolver los datos de la información del curso del usuario
        return response()->json([
            'courseInfo' => $courseInfo,
        ]);
    }

    public function dataFavorites($id)
    {
        // Obtener la información del curso del usuario actual
        $favorites = Favorite::where('user_id', $id)->get();

        // Devolver los datos de la información del curso del usuario
        return response()->json([
            'favorites' => $favorites,
        ]);
    }

    // Funcion para mostar la vista request
    public function request()
    {
        return Inertia::render('Home/Request', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION
        ]);
    }
}
