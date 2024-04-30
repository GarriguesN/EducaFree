<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    // Funcion para agregar una nueva lección
    public function addLesson(CourseRequest $request, $id){
        // Crear una nueva lección
        $lesson = new Lesson();
        $lesson->name = $request->input('name');
        $lesson->description = $request->input('description');
        $lesson->course_id= $id;

        // Comprobar que existe el curso
        $course = Course::findOrFail($id);
        $lesson->save();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }
        return redirect()->route('dashboard.course', $id); 
    }

    // Funcion para añadir un PDF a una lección
    public function addPDF(Request $request, $id, $courseId){
        // Buscar esa lección
        $lesson = Lesson::findOrFail($id);
        $pdf = $request->file('file');

        // Comprobar que existe el pdf y guardarlo en la carpeta 'public/PdfLessons'
        if(isset($pdf)){
            $lesson->pdf_url = $pdf;
            $pdfName = $lesson->name;
            $pdf->storeAs('public/PdfLessons', $pdfName);
            $lesson->pdf_url  = asset('storage/PdfLessons/' .$pdfName);
        }

        // Guardar la actualizacion
        $course = Course::findOrFail($courseId);
        $lesson->save();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }

        return redirect()->route('dashboard.course', $courseId); 
    }

    // Eliminar PDF
    public function deletePDF($id, $courseId){
        $lesson = Lesson::findOrFail($id);
        $lesson->pdf_url = null;

        $course = Course::findOrFail($courseId);
        $lesson->save();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }
        
        return redirect()->route('dashboard.course', $courseId); 
    }

    // Eliminar leccion
    public function deleteLesson($id, $courseId){
        // Obtener el curso
        $course = Course::findOrFail($courseId);
        // Eliminar la leccion
        Lesson::where('id', $id)->delete();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }
        return redirect()->route('dashboard.course', $courseId); 
    }

    // Editar leccion
    public function editLesson(CourseRequest $request, $id, $courseId){
        $lesson = Lesson::find($id);
        $lesson->name = $request->input('name');
        $lesson->description = $request->input('description');

        $course = Course::findOrFail($courseId);
        $lesson->save();

        // Si el curso es de un 'uploader' (usuario), redirigir a su ruta
        if ($course->uploader && $course->revision_status == 'pending') {
            return redirect()->route('upload');
        }
        
        return redirect()->route('dashboard.course', $courseId); 
    }
}
