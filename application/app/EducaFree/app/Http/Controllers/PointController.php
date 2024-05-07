<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PointController extends Controller
{
    // Funcion para agregar un punto
    public function addPoint(Request $request, $id, $courseId){

        //Añadir aqui el cambio de estilos
        $explanation = $request->input('explanation');
        
        $point = new Point();
        $point->name = $request->input('name');
        $point->explanation = $explanation;
        $point->lesson_id= $id;

        $course = Course::findOrFail($courseId);
        $point->save();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }

        return redirect()->route('dashboard.course', $courseId); 
    }


    // Funcion para eliminar un punto
    public function deletePoint($id, $courseId){
        $course = Course::findOrFail($courseId);
        Point::where('id', $id)->delete();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }
        
        return redirect()->route('dashboard.course', $courseId); 
    }

    // Funcion para editar un punto
    public function editPoint(Request $request, $id, $courseId){
        $explanation = $request->input('explanation');

        $point = Point::find($id);
        $point->name = $request->input('name');
        $point->explanation = $explanation;

        $course = Course::findOrFail($courseId);
        $point->save();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }
        return redirect()->route('dashboard.course', $courseId); 
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas de validación según tus necesidades
        ]);

        $pointFolder = 'public/ImagesPoints';

        // Guarda la imagen en el almacenamiento de Laravel y devuelve la ruta
        $imagePath = $request->file('image')->store($pointFolder);

        // Genera la URL de la imagen
        $imageUrl = asset(str_replace('public', 'storage', $imagePath));

        return response()->json(['url' => $imageUrl]);
    }
}
