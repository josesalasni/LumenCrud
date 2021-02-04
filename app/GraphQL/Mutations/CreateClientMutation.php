<?php 
namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Client;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;

class CreateClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createClientMutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Client');
    }

    public function args(): array
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'date' => ['name' => 'date', 'type' => Type::nonNull(Type::string())],
            'company' => ['name' => 'company' , 'type' => Type::nonNull(Type::string()) ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $newClient = new Client;
        $newClient->name = $args['name'];
        $newClient->date = $args['date'];
        $newClient->company = $args['company'];
        $newClient->save();

        return $newClient;
    }
}