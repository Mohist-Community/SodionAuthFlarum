<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Flarum\User\User;
use Mohist\SodionAuthFlarum\Provider\UserProvider;
use Mohist\SodionAuthFlarum\Response\Response;

class LoginController extends Controller
{
    protected function hand($request)
    {
        $username=$request->username;
        $password=$request->password;
        /** @var User $user */
        $user=User::where('username', $username);
        if(!$user){
            $user=User::where('username', 'like', '%'.$this->escapeLikeString($username).'%')
                ->first();
            if($user){
                return Response::name_incorrect($user->username);
            }else{
                return Response::no_user();
            }
        }
        if($user->checkPassword($password)){
            return Response::ok();
        }
        return Response::password_incorrect();
    }
    private function escapeLikeString($string)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $string);
    }
}
