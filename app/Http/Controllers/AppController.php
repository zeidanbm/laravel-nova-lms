<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\BaseController;

class AppController extends BaseController
{
    public function __construct(AuthManager $auth)
    {
        parent::__construct($auth);
    }
}
