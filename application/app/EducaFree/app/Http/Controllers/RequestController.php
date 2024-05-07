<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RequestRequest;
use Inertia\Inertia;

class RequestController extends Controller
{
    // Funcion para eliminar la request
    public function delete($id){
        ModelsRequest::where('id', $id)->delete();
        return Inertia::location(route('dashboard.requests'));
    }

    // Funcion para completar la request
    public function complete($id){
        ModelsRequest::where('id', $id)->update(['completed' => 1]);
        return Inertia::location(route('dashboard.requests'));
    }

        /**
     * Store a newly created resource in storage.
     * @param App\Http\Requests\RequestRequest
     * @return \Illuminate\Http\Response
     */

    //Funcion para almacenar la request en la base de datis
    public function store(RequestRequest $request)
    {
        $requestData = $request->validated();
        $requestData['user_id'] = auth()->id();
        ModelsRequest::create($requestData);      
        return redirect()->route('home');      
    }
}
