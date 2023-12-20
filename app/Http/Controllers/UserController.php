<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request) {
        $value = Validator::make($request->all(), [
            "name"=> "required",
            "email"=> "required|unique:users",
            "password"=> "required|min:8"
        ]);

        if($value->fails()) {
            return response()->json(['error'=> $value->errors()],404);
        }
        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password
        ]);
        return response()->json(['success'=> true],200);
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
            return response()->json(['success'=> true],200);
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
        return response()->json(["success"=> true],200);
    }
}
