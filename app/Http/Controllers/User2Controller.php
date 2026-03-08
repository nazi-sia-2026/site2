<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use DB;
use App\Services\User2Service;

class User2Controller extends Controller {
    use ApiResponser;


    /**
     * THe service to consume the users2 service
     * @var User2Service
     */
    public $user2Service;
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(User2Service $user2Service){
        $this->user2Service = $user2Service;
    }
}