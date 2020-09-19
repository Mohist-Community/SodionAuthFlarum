<?php


namespace Mohist\SodionAuthFlarum\Provider;


use Flarum\User\User;
use Flarum\User\UserRepository;
use Illuminate\Support\Facades\DB;

class UserProvider
{
    public function canJoin($username){
        $user=User::where('username', $username);
        if(!$user){
            $user=User::where('username', 'like', '%'.$this->escapeLikeString($username).'%')
                ->first();
            if($user){
                return null;
            }else{
                return false;
            }
        }
        return true;
    }
    public function login($username,$password){
        /** @var User $user */
        $user=User::where('username', $username);
        if(!$user){
            $user=User::where('username', 'like', '%'.$this->escapeLikeString($username).'%')
                ->first();
            if($user){
                return $user->username;
            }else{
                return false;
            }
        }
        if($user->checkPassword($password)){
            return true;
        }
        return false;
    }
    public function loginEmail($email,$password){
        $user=(new UserRepository())->findByEmail($email);
        if(!$user){
            return null;
        }
        if($user->checkPassword($password)){
            return $user->username;
        }else{
            return false;
        }
    }
    public function register($username,$email,$password){
        $user=User::where('username',$username)->first();
        if($user){
            return 0;
        }
        $user=User::where('email',$email)->first();
        if($user){
            return 1;
        }
        $user=User::register($username,$email,$password);
        if(!$user){
            return false;
        }
        return true;
    }
    private function escapeLikeString($string)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $string);
    }
}
