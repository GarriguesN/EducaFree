<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\CourseInfo;
use App\Models\Favorite;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function show(Request $request){
        $user = $request->user();
        $courseInfo = CourseInfo::where('user_id', $user->id)
        ->with(['course' => function ($query) {
            $query->withCount('lessons'); // Obtener el recuento de lecciones por curso
        }])->get();

        $favorites = Favorite::where('user_id', $user->id)->get();

        $userId = $user->id;
        $rankingData = User::selectRaw('(SELECT COUNT(*) FROM `course_info` WHERE `users`.`id` = `course_info`.`user_id` AND `progress` = 100) AS completed_courses_count, `users`.`id`')
            ->orderByDesc('completed_courses_count')
            ->get();
        
    $userIndex = $rankingData->search(function ($user) use ($userId) {
        return $user->id === $userId;
    });
    
    // Sumar 1 al índice para obtener la posición real (ya que los índices comienzan desde 0)
    $userRank = $userIndex !== false ? $userIndex + 1 : null;

        return Inertia::render('Profile/Profile', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'coursesInfo' => $courseInfo,
            'userRank' => $userRank,
            'favorites' => $favorites
        ]);
    }
    // Funcion para eliminar el usuario
    public function delete($id){
        User::where('id', $id)->delete();
        return Inertia::location(route('dashboard.users'));
    }

    // Funcion para dar rol Administrador
    public function giveAdmin($id){
        $user = User::where('id', $id)->first();
        $user->assignRole('admin');
        return Inertia::location(route('dashboard.users'));
    }

    // Funcion para dar rol Editor
    public function giveEditor($id){
        $user = User::where('id', $id)->first();
        $user->assignRole('editor');
        return Inertia::location(route('dashboard.users'));
    }

    // Funcion para dar rol Collaborador
    public function giveCollaborator($id){
        $user = User::where('id', $id)->first();
        $user->assignRole('collaborator');
        return Inertia::location(route('dashboard.users'));
    }

    // Funcion para eliminar rol Administrador y Editor
    public function deleteRoles($id){
        $user = User::where('id', $id)->first();
        $user->removeRole('admin');
        $user->removeRole('editor');
        return Inertia::location(route('dashboard.users'));
    }

    // Funcion para actualizar la informacion del usuario, nombre y email
    public function updateInfo(UpdateInfoRequest $request, $id) {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validated();
    
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        
        $user->save();

        return redirect()->route('profile.show')->with('message', 'Profile updated successfully.');
    }

    // Funcion para actualizar la contraseña del usuario
    public function updatePassword(UpdatePasswordRequest $request, $id) {
        $user = User::find($id);
        if (!Hash::check($request['currentPassword'], $user->password)) {
            // Si la contraseña actual no coincide con la del usuario, se devuelve un error al formulario
            return redirect()->back()->withErrors(['currentPassword' => 'The current password is incorrect']);
        }else{
            $user->password = Hash::make($request['newPassword']);
            $user->save();
        }
        $authenticatedSessionController = app(AuthenticatedSessionController::class);
        $logoutResponse = $authenticatedSessionController->destroy($request);

        return Inertia::render('Auth/Login')->with('flash', ['message' => 'Password updated successfully.']);
     }

     // Funcion para eliminarse a si mismo
     public function deleteYourself($id, Request $request){
        $user = User::findOrFail($id);
        $user->delete();
        // Cerrar la sesion del usuario
        $authenticatedSessionController = app(AuthenticatedSessionController::class);
        $logoutResponse = $authenticatedSessionController->destroy($request);
        
        return redirect()->route('home');
    }

    // Funcion para obtener los datos del ranking
    public function dataRanking()
    {
        // Obtener los usuarios ordenados por la cantidad de cursos completados
        $rankingData = User::select('id', 'name')
        ->withCount(['coursesInfo' => function ($query) {
            $query->where('progress', 100); // Solo contar los cursos completados
        }])
        ->orderByDesc('courses_info_count')
        ->take(10)
        ->get();

        // Devolver los datos del ranking como una respuesta JSON
        return response()->json($rankingData);
    }

    // Funcion para mostrar vista reset
    public function reset(){
        return Inertia::render('Auth/Reset', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'status' => session('status'),
            'phpVersion' => PHP_VERSION
        ]);
    }

    // Funcion para comprobar email y enviar correo
    public function sendEmail(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided email address does not exist.'],
            ]);
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if($status == "passwords.sent"){
                return back()->with(['status' => ['message' => "Email sent, please check your inbox", 'type' => 'Success']]);
            }
        } catch (Exception $e) {
            return back()->with(['status' => ['message' => "An error occurred while sending the email. Please try again later.", 'type' => 'Error']]);
        }
    }

    // Funcion para resetear la contraseña
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        if($status == "passwords.reset"){
            $status = ($status == "passwords.reset") ? "Password reset successful!" : session('status');

            return Inertia::render('Auth/Login', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'status' => $status,
                'phpVersion' => PHP_VERSION
            ]);
        }
    }

    public function checkEmail(Request $request) {
        $email = $request->input('email');

        $emailParts = explode('@', $email);
        $domain = isset($emailParts[1]) ? $emailParts[1] : null;

        if(checkdnsrr($domain, 'MX')){
            return true;
        }else{
            return false;
        }
    }
}
