<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
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
            'username' => 'required|max:20',
            //'password' => 'required|string|min:6|max:20',
            //'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female'
        ];

        $this->validate($request,$rules);
        $user = User::create($request->all());
        //$user = User::create($request->only('username','password','gender'));
        //return response()->json($user,201);
        return $this->successResponse($user, Response::HTTP_CREATED);
    }
    public function show($id)
    {   
        $user = User::findOrFail($id);
        return $this->successResponse($user);
        //$user = User::where('id',$id)->first();
        //if(!$user){
        //    return response()->json(['message' => 'User not Found.'],404);
        //}
        //return response()->json($user,200);
    }
    public function delete($id){
            $user = User::findOrFail($id);
            $user->delete();
            return $this->successResponse($user);
        //$user = User::where('id',$id)->first();
        //if($user) { 
           // $user->delete();
            //return response()->json(['message' => 'User deleted successfully.'],200);
        //}
        //return response()->json(['message' => 'User not Found.'],404);
    }
    /**
     * Update an existing user
     */
    public function update(Request $request, $id){
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender'   => 'in:Male,Female',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($id);
        $user->fill($request->all());

        if($user->isClean()){
            return $this->errorResponse(
                'At least one value must change', 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $user->save();
        return $this->successResponse($user);
    }
    //public function update($id, Request $request){
        //$user = User::where('id', $id)->first();
        //if(!$user){ 
            //return response()->json(['message' => 'User not Found.'],404);
        //}

        //$rules = [
            //'username' => 'string|unique:users,username,'.$id.'|max:20',
            //'password' => 'string|min:6|max:20',
        //];
        //$this->validate($request, $rules);
        //$user->update($request->all());
        //return response()->json($user,200); 
}
