<?php

namespace App\Http\Controllers;

use App\Models\Campeonato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CampeonatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campeonato = Campeonato::all();
        return response()->json(["campeonato"=>$campeonato],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nombre"=> ["required","string","unique:campeonatos,nombre"],
            "disciplina"=> ["required"],
        ]);
        if($validator->fails()) {
            return response()->json(["erros"=>$validator->errors()],400);
        }

        Campeonato::create(array_merge($request->all(),["slug"=>Str::slug($request->nombre)]));
        return response()->json(["menssage"=> "Campeonato creado con exito"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $campeonato = Campeonato::find($id);
        if(!$campeonato) {
            return response()->json(["menssage"=>"No se encuentra el campeonato"],404);
        }
        return $campeonato;
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $campeonato = Campeonato::find($id);
        if(!$campeonato) {
            return response()->json(["menssage"=> "No existe el campeonato"],404);
        }
        $validator = Validator::make([$request->all()],[
            "nombre"=> ["string","min:4"],
            "disciplina"=> ["string","min:4"]
        ]);
        if($validator->fails()) {
            return response()->json(["errors"=>$validator->errors()],400);
        }
        $campeonato->update($request->all());
        return response()->json(["menssage"=> "Campeonato actualizado correctamente"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $campeonato = Campeonato::find($id);
        if(!$campeonato) {
            return response()->json(["menssage"=> "No se encuentra el campeonato"],404);
        }
        $campeonato->delete();
        return response()->json(["menssage"=> "Campeonato eliminado con exito"],200);
    }
}
