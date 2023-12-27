<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function store(Request $request) {
        $values = Validator::make($request->all(), [
            "name"=> "required",
            "email"=> "required|unique:users",
            "password"=> "required|min:8"
        ]);

        if($values->fails()) {
            return response()->json(['error'=> $values->errors()],404);
        }
        // $validated = $request->validated();

        // if($validated->fails()) {
        //     return response()->json([$validated->errors()],404);
        // }

        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);
            return response()->json(['successs'=> true],200);

    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'password'=> 'required|min:8'
        ]);
        if($validator->fails()) {
            return response()->json(['error'=> $validator->errors()],404);
        }
        if(Auth::attempt(['email'=> $request->email,'password'=> $request->password])) {
            return response()->json(['successs'=> true],200);
        }
        else {
            return response()->json(['error'=> 'Autorized'],404);
        }
        // $user=User::where(['email', $request->email])->first();

    }

    public function destroy($id) {
        $user = User::find($id);
        if( !$user ) {
            return response()->json(['error'=>"No se encuentra al usuario con el id: ".$id],404);
        }
        $user->delete();
        return response()->json(["successs"=> true],200);
    }
    public function update(Request $request, $id) {
        $user = User::find($id);
        if(!$user) {
            return response()->json(["error"=> "Usuario no encontrado"],404);
        }
        $user->update(
            $request->all()
        );

        return response()->json(["successs"=> "Datos actualizados conrrectamente"],200);
    }
}
