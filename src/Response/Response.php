<?php


namespace Mohist\SodionAuthFlarum\Response;

/**
 * Class Response
 * @package Mohist\SodionAuthFlarum\Response
 * @method static Response ok(...$parms);
 * @method static Response user_exist(...$parms);
 * @method static Response email_wrong(...$parms);
 * @method static Response email_exist(...$parms);
 * @method static Response no_user(...$parms);
 * @method static Response password_incorrect(...$parms);
 */
class Response
{
    public static function unknown($code,$message,...$parms){
        return call_user_func(
            [self::class,'__callStatic'],
            'unknown',
            array_merge([
                'code'=>$code,
                'message'=>$message
            ],$parms)
        );
    }
    public static function name_incorrect($correct,...$parms){
        return call_user_func(
            [self::class,'__callStatic'],
            'unknown',
            array_merge([
                'correct'=>$correct
            ],$parms)
        );
    }

    public $data=[];
    public function __construct($parms)
    {
        foreach ($parms as $key=>$value){
            $this->$key=$value;
        }
    }
    public function __get($name)
    {
        return $this->data[$name];
    }
    public function __set($name, $value)
    {
        $this->data[$name]=$value;
    }

    public static function __callStatic($key, $parms)
    {
        return (new Response(array_merge(
            ['result'=>$key],
            $parms
        )));
    }
}
