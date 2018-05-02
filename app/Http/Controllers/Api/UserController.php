<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show($id){
       $user = User::find($id);
       dd($user);
       return view('',['user'=>$user]);
    }
}
