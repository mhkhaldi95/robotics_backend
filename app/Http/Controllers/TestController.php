<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function __construct(Request $request)
    {
        // $this->user = Auth::guard($request->attributes->get("guard"))->user();
        parent::__construct($request);
        $this->middleware("authorizor:students");
    }
    public function test(){
       
    }
}
