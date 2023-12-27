<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class TorneoController extends Controller
{
    public function index() {
        $torneos = Torneo::all();
        return response()->json(["torneos"=>$torneos],200);
    }
    public function show($id) {
        $validator = Validator::make($id, [
            $id=>["required","integer"],
        ]);
        if($validator->fails()) {
            return response()->json(["message"=> $validator->errors()],404);
        }
        $torneo = Torneo::find($id);
        return response()->json(["torneo"=> $torneo],200);
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name"=>["required","string"],
            "year"=>["required","integer"],
            "categoria_id"=>["required","integer","exists:categorias,id"],
        ]);
        if($validator->fails()) {
            return response()->json(["message"=> $validator->errors()],404);
        }
        Torneo::create(array_merge($request->all(),["slug"=>Str::slug($request->name)]));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "name"=>["string","min:3"],
            "year"=>["integer"],
            "categoria_id"=>["integer","exists:categorias,id"]
        ]);

        if($validator->fails()) {
            return response()->json(["message"=> $validator->errors()],404);
        }
        $torneo = Torneo::find($id);
        if($torneo->name == $request->name) {
            $torneo->update($request->all());
        }
        else {
            $torneo->update(array_merge($request->all(),["slug"=>Str::slug($request->name)]));
        }
        return response()->json(["torneo"=> $torneo],200);
    }

    public function destroy($id) {
        $torneo = Torneo::find($id);
        if(!$torneo) {
            return response()->json(["menssage"=> "No existe el torneo"],404);
        }
        $torneo->delete();
        return response()->json(["success"=> "Torneo eliminado con exito"],200);
    }
}
