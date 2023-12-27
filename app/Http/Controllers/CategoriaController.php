<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = Categoria::all();
        if(!$categoria) {
            return response()->json(["menssage"=>"No existen categorias registradas"],404);
        }
        return response()->json(["categoria"=> $categoria],200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=> "required|unique:categorias,name",
            "minEdad"=> "required|integer|min:1",
            "campeonato_id"=> "required|exists:campeonatos,id"
        ]);

        if($validator->fails()) {
            return response()->json(["errors"=> $validator->errors()],404);
        }

        $categoria =Categoria::create(array_merge($request->all(),["slug"=>Str::slug($request->name)]));

        return response()->json(["categoria"=> $categoria],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $categoria = Categoria::findOrFail($categoria->id);
        if(!$categoria) {
            return response()->json(["menssage"=>"No se encuentra a la categoria solicitada"],404);
        }
        return response()->json(["categoria"=>$categoria],200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "name"=> "string|min:8",
            "minEdad"=> "integer|min:1",
            "campeonato_id"=> "integer|exists:campeonatos,id",
        ]);
        if($validator->fails()) {
            return response()->json(["errors"=> $validator->errors()],404);
        }
        $categoria = Categoria::findOrFail($id);
        if(!$categoria) {
            return response()->json(["error"=> "No existe la categoria solicitada"],404);
        }
        if($request->name !== $categoria->name) {
            $categoria->update(array_merge($request->all(),["slug"=> Str::slug($request->name)]));
        }
        else {
            $categoria->update($request->all());
        }
        return response()->json(["categoria"=> $categoria],404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if(!$categoria) {
            return response()->json(["error"=>"No existe la categoria"]);
        }
        $categoria->delete();
        return response()->json(["success"=> "Categoria elimindada con exito"],200);
    }
}
