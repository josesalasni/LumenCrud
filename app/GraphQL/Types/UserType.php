<?php

namespace App\GraphQL\Types;

use App\Model\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{ 

    protected $attributes = [
        'name' => 'User',
        'description' => 'Collection of Users',
        'model' => User::class
    ];

    public function fields() : array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email del usuario',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nombre del usuario',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Contraseña del usuario',
            ]
        ];
    }
}