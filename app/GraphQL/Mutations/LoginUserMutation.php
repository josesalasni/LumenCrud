<?php 
namespace App\GraphQL\Mutations;

use Closure;
use App\Models\User;
use App\Helpers\JwtHelper;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'loginUserMutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Token');
    }

    public function getAuthorizationMessage(): string
    {
        return 'Error conectando al servicio, token no proporcionado';
    }

    public function args(): array
    {
        return [
            'email' => ['name' => 'email', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $User = User::where('email', $args['email'])->first() ;

        if(!$User) {
            return null;
        }

        $credentials = [
            'email' => $args['email'],
            'password' => $args['password']
        ];

        if (! $token = Auth::attempt($credentials)) {
            throw new \Error("Error conectando al servicio");
        }

        error_log($token);

        return $this->respondWithToken($token);
        
    }

    public function respondWithToken($token)
    {
        $tokenResponse = [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];

        return $tokenResponse;
    }
}