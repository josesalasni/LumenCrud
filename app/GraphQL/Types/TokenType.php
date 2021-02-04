<?php

namespace App\GraphQL\Types;

use App\Models\Token;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TokenType extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'TokenType',
        'description' => 'A type',
        'model' => Token::class
    ];

    /**
     * define field of type
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Token key'
            ],
            'expires_in' => [
                'type' =>  Type::nonNull(Type::string()),
                'description' => 'date expire'
            ],
            'token_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Token type'
            ],
        ];
    }
}