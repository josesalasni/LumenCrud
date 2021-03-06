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

class UpdateClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateClientMutation'
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
            'date' => ['name' => 'date', 'type' => Type::nonNull(Type::string())],
            'company' => ['name' => 'company' , 'type' => Type::nonNull(Type::string()) ],
            'name' => ['name' => 'name' , 'type' => Type::nonNull(Type::string()) ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $Client = Client::find($args['id']);
        if(!$Client) {
            return null;
        }

        $Client->name = $args['name'];
        $Client->date = $args['date'];
        $Client->company = $args['company'];
        $Client->save();

        return $Client;
    }
}