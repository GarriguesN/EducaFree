<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
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
        dd('hola');
        // Encuentra la respuesta por su ID
        $reply = CommentReply::findOrFail($id);

        // Elimina la respuesta
        $reply->delete();

        // Redirecciona de regreso a la página del curso
        return Inertia::location(route('course', $idCourse));
    }

    //Funcion que devulve un json con todos los datos de los comentarios de un curso ($id)
    public function dataCourseComments($id)
    {

        $comments = Comment::with('user', 'replies.user')
            ->where('course_id', $id)
            ->paginate(5);

        return response()->json([
            'comments' => $comments,
        ]);
    }
}
