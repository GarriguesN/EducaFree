<?php

namespace Laravel\Jetstream\Http\Controllers\Inertia;

use App\Models\CourseInfo;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Agent;
use Laravel\Jetstream\Jetstream;

class UserProfileController extends Controller
{
    use Concerns\ConfirmsTwoFactorAuthentication;

    /**
     * Show the general profile settings screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
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

        return Jetstream::inertia()->render($request, 'Profile/Profile', [
            'sessions' => $this->sessions($request)->all(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'coursesInfo' => $courseInfo,
            'userRank' => $userRank,
            'favorites' => $favorites
        ]);
    }

    /**
     * Get the current sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn ($agent) => $agent->setUserAgent($session->user_agent));
    }
}
