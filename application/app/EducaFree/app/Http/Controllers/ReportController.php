<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    // Funcion para permitir un comentario (no borrarlo)
    public function pass($id){
        $report = Report::findOrFail($id);
        $report->delete();

        return Inertia::location(route('dashboard.reports'));
    }

    // Funcion para borrar un comentario o una respuesta
    public function deleteComment($idComment, $type){
        // Si el tipo es comentario, se busca el comentario y se elimina
        if($type == 'comment') {
            $comment = Comment::findOrFail($idComment);
            $comment->delete();
            return Inertia::location(route('dashboard.reports'));
            // Si el tipo es respuesta, se busca la respuesta y se elimina
        }else if($type == 'reply'){
            $comment = CommentReply::findOrFail($idComment);
            $comment->delete();
            return Inertia::location(route('dashboard.reports'));
        }
    }

    // Funcion para reportar un comentario o una respuesta
    public function report($id, $type, $reason){
        // Si el tipo es comentario, se crea un nuevo reporte de comentario
        if ($type == "comment"){
            $report = new Report();
            $report->comment_id= $id;
            $report->user_id = auth()->user()->id;
            $report->reason = $reason;
            // Si el tipo es respuesta, se crea un nuevo reporte de respuesta
        }else if( $type == "reply" ){
            $report = new Report();
            $report->reply_id= $id;
            $report->user_id = auth()->user()->id;
            $report->reason = $reason;
        }
        $report->save();
    }
}
