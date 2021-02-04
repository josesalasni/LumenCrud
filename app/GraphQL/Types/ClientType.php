<?php

namespace App\GraphQL\Types;

use App\Models\Client;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ClientType extends GraphQLType
{ 

    protected $attributes = [
        'name' => 'Client',
        'description' => 'Collection of Clients',
        'model' => Client::class
    ];

    public function fields() : array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id del cliente',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nombre del cliente',
            ],
            'company' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Empresa que trabaja',
            ],
            'date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Fecha nacimiento',
            ],
        ];
    }
}