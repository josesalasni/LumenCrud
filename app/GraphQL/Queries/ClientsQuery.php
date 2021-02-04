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


class ClientsQuery extends Query
{
    protected $attributes = [
        'name' => 'clients',
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return false;
            //return new \Error("Error conectando al servicio, Token expirado");
    
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return false;
            //return new \Error("Error conectando al servicio, token invalido");
    
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return false;
            //return new \Error("Error conectando al servicio, token no proporcionado");
        }

        return true;
    }

    public function getAuthorizationMessage(): string
    {
        return 'Error conectando al servicio, token no proporcionado';
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Client'));
    }

    public function resolve($root, $args)
    {
        return Client::all();
    }

    
}