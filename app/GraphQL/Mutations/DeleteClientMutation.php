<?php 
namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Client;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;

class DeleteClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteClientMutation'
    ];

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