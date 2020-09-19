<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Flarum\User\User;
use Mohist\SodionAuthFlarum\Response\Response;

class RegisterController extends Controller
{
    protected function hand($request)
    {
        $username=$request->username;
        $email=$request->email;
        $password=$request->password;
        $user=User::where('username',$username)->first();
        if($user){
            return Response::user_exist();
        }
        $user=User::where('email',$email)->first();
        if($user){
            return Response::email_exist();
        }
        $user=User::register($username,$email,$password);
        if(!$user){
            return Response::unknown('flarum_error','flarum error');
        }
        $user->saveOrFail();
        return Response::ok();
    }
}
