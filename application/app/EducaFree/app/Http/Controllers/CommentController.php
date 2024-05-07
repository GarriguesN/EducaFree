<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    //Funcion que recoje datos del form a traves del $request 
    //y sube el comentario al curso ($id) a la base de datos
    public function comment($id, CommentRequest $request)
    {
        $user = $request->user();

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->course_id = $id;
        $comment->comment = $request->input('comment');
        $comment->save();

        return Inertia::location(route('course', $id));
    }

    //Funcion que recoje datos del form a traves del $request 
    // y sube la respuesta del comentario ($id) a la base de datos
    public function replyComment($id, CommentRequest $request)
    {
        $user = $request->user();
        $reply = new CommentReply();
        $reply->comment_id = $id;
        $reply->user_id = $user->id;
        $reply->comment = $request->comment;
        $reply->save();

        // Redirecciona de regreso a la página del curso a traves de un input hidden del form
        return Inertia::location(route('course', $request->id));
    }

    //Funcion que recoje datos del form a traves del $request 
    // y edita el comentario ($id) de la base de datos
    public function editComment($id, CommentRequest $request)
    {

        $comment = Comment::findOrFail($id);
        $comment->comment = $request->input('comment');
        $comment->save();

        // Redirecciona de regreso a la página del curso a traves de un input hidden del form
        return Inertia::location(route('course', $request->id));
    }

    //Funcion que recoje datos del form a traves del $request y edita la respuesta del comentario ($id) de la base de datos
    public function editReply($id, CommentRequest $request)
    {

        $comment = CommentReply::findOrFail($id);
        $comment->comment = $request->input('comment');
        $comment->save();

        // Redirecciona de regreso a la página del curso a traves de un input hidden del form
        return Inertia::location(route('course', $request->id));
    }

    //Funcion que elimina el comentario ($id) de la base de datos
    public function deleteComment($id, $idCourse)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        // Redirecciona de regreso a la página del curso ($idCourse)
        return Inertia::location(route('course', $idCourse));
    }

    public function deleteReply($id, $idCourse)
    {
        // Encuentra la respuesta por su ID
        $reply = CommentReply::findOrFail($id);

        // Elimina la respuesta
        $reply->delete();

        // Redirecciona de regreso a la página del curso
        return Inertia::location(route('course', $idCourse));
    }

    //Funcion para dar like a un comentario (no reply)
    public function addFavorites($id, Request $request, $idCourse){
        $user = $request->user();

        $like = CommentLike::where('user_id', $user->id)
        ->where('comment_id', $id)
        ->first();

        if ($like) {
            // If the user has already liked the comment, remove the like
            CommentLike::where('user_id', $user->id)
            ->where('comment_id', $id)
            ->delete();
        } else {
            // If the user has not liked the comment, add a new like
            $newLike = new CommentLike();
            $newLike->user_id = $user->id;
            $newLike->comment_id = $id;
            $newLike->save();
        }
    

        return Inertia::location(route('course', $idCourse));
    }

    //Funcion que devulve un json con todos los datos de los comentarios de un curso ($id)
    public function dataCourseComments($id, Request $request)
    {
        // Retrieve the userId from the request query
        $userId = $request->query('userId');
        // Retrieve comments with user, replies.user relationships, and favorites count
        $comments = Comment::with(['user', 'replies.user'])
            ->withCount('favorites') // Count the favorites for each comment
            ->where('course_id', $id)
            ->orderBy('favorites_count', 'desc') // Order by favorites count
            ->paginate(5); // Paginate the results

        // Include the favorite status for the current user
        $comments->each(function($comment) use ($userId) {
            // Check if the user has favorited the comment
            $comment->is_favorited = $comment->favorites()
                ->where('user_id', $userId)
                ->exists();
        });

        return response()->json([
            'comments' => $comments,
        ]);
    }
}
