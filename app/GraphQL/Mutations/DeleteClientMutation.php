<?php 
namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Client;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class DeleteClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteClientMutation'
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
        return GraphQL::type('Client');
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::Int())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $Client = Client::find($args['id']);
        $clienteRespaldo = $Client;
        if(!$Client) {
            throw new \Error("Cliente no encontrado, intente con otro registro.");
        }
        $Client->delete();

        return $clienteRespaldo;
    }
}