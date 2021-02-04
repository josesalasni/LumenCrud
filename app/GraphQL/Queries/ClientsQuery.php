<?php

namespace App\GraphQL\Queries;

use App\Models\Client;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ClientsQuery extends Query
{
    protected $attributes = [
        'name' => 'clients',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Client'));
    }

    public function resolve($root, $args)
    {
        return Client::all();
    }

    
}