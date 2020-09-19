<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Flarum\Api\JsonApiResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mohist\SodionAuthFlarum\Response\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tobscure\JsonApi\Document;

class Controller implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response=$this->hand((Object)$request->getParsedBody());
        return new JsonResponse($response->data);
    }
    protected function hand($request){
        switch ($request->action){
            case 'register':
                return (new RegisterController())->hand($request);
            case 'login':
                return (new LoginController())->hand($request);
            case 'loginEmail':
                return (new LoginEmailController())->hand($request);
            case 'join':
                return (new JoinController())->hand($request);
            default:
                return Response::unknown('flarum_error','ah?'.$request->action);
        }
    }
}
