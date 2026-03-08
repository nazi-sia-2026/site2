<?php

namespace App\Services;
use App\Traits\ConsumeExternalService;

class User2Service{
    use ConsumeExternalService;
    /**
     * The base uri to consume the users2 service
     * @var string
     */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.users2.base_uri');
    }
    /**
     * Obtain the full list of users from the users2 service
     * @return string
     */
    public function obtainUsers2()
    {
        return $this->performRequest('GET', '/users');
    }
}