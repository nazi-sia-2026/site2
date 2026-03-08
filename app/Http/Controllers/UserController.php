<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use DB;

Class UserController extends Controller {
    use ApiResponser;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsers(){
        //$users = User::all();
        //return response()->json($users,200);
        $users = DB::connection('mysql')
            ->select("SELECT * FROM users");

            //return response()->json($users,200);
            return $this->successResponse($users);
    }
    /**
     * Return the list of users
     * @return Illuminate\Http\Response
     */
    public function index(){
        $users = User::all();
        //return response()->json($users,200);
        return $this->successResponse($users);
    }
    public function add(Request $request){
        $rules = [
            'username' => 'required|string|unique:users,username',
            //'password' => 'required|string|min:6|max:20',
            //'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female'
        ];

        $this->validate($request,$rules);
        //$user = User::create($request->all());
        $user = User::create($request->only('username','password','gender'));
        return response()->json($user,201);
        //return $this->successResponse($users, Response::HTTP_CREATED);
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