<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Flarum\User\User;
use Flarum\User\UserRepository;
use Mohist\SodionAuthFlarum\Provider\UserProvider;
use Mohist\SodionAuthFlarum\Response\Response;

class LoginEmailController extends Controller
{
    protected function hand($request)
    {
        $email=$request->email;
        $password=$request->password;
        $user=(new UserRepository())->findByEmail($email);
        if(!$user){
            return Response::no_user();
        }
        if($user->checkPassword($password)){
            return Response::ok([
                'correct'=>$user->username
            ]);
        }else{
            return Response::password_incorrect();
        }
    }
}
