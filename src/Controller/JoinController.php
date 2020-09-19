<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Flarum\User\User;
use Mohist\SodionAuthFlarum\Provider\UserProvider;
use Mohist\SodionAuthFlarum\Response\Response;

class JoinController extends Controller
{
    protected function hand($request)
    {
        $username=$request->username;
        $user=User::where('username', $username);
        if(!$user){
            $user=User::where('username', 'like', '%'.$this->escapeLikeString($username).'%')
                ->first();
            if($user){
                return Response::name_incorrect($username);
            }else{
                return Response::no_user();
            }
        }
        return Response::ok();
    }
    private function escapeLikeString($string)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $string);
    }
}
