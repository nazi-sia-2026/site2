<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use DB;
use App\Services\User1Service;

class User1Controller extends Controller {
    use ApiResponser;


    /**
     * THe service to consume the users1 service
     * @var User1Service
     */
    public $user1Service;
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(User1Service $user1Service){
        $this->user1Service = $user1Service;
    }
    
}