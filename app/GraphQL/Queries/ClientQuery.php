<?php

namespace App\GraphQL\Queries;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;


class ClientQuery extends Query
{
    protected $attributes = [
        'name' => 'client',
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            
            throw new \Error("Error conectando al servicio, Token expirado");
    
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            throw new \Error("Error conectando al servicio, token invalido");
    
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    
            throw new \Error("Error conectando al servicio, token no proporcionado");
        }

        return true;
    }

    public function getAuthorizationMessage(): string
    {
        return 'Error conectando al servicio, token no proporcionado';
    }


    public function type() : Type
    {
        return GraphQL::type('Client');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Client::findOrFail($args['id']);
    }
}