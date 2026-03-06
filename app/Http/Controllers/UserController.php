<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

Class UserController extends Controller {
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsers(){
        $users = User::all();
        return response()->json($users,200);
    }
    public function index(){
        $users = User::all();
        return response()->json($users,200);
    }
    public function add(Request $request){
        $rules = [
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6|max:20',
        ];

        $this->validate($request,$rules);
        $user = User::create($request->all());
        return response()->json($user,201);
    }
    public function show($id)
    {
        $user = User::where('id',$id)->first();
        if(!$user){
            return response()->json(['message' => 'User not Found.'],404);
        }
        return response()->json($user,200);
    }
    public function delete($id){
        $user = User::where('id',$id)->first();
        if($user) { 
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.'],200);
        }
        return response()->json(['message' => 'User not Found.'],404);
    }
    public function update($id, Request $request){
        $user = User::where('id', $id)->first();
        if(!$user){ 
            return response()->json(['message' => 'User not Found.'],404);
        }

        $rules = [
            'username' => 'string|unique:users,username,'.$id.'|max:20',
            'password' => 'string|min:6|max:20',
        ];
        $this->validate($request, $rules);
        $user->update($request->all());
        return response()->json($user,200); 
    }
}