<?php
return [
    'paths' => [
        '/api/user/getAll' => [
            'get' => [
                '@OA\Get' => [
                    'summary' => 'Obtener todos los usuarios',
                    'description' => 'Devuelve una lista completa de todos los usuarios registrados.',
                    'tags' => ['User'],
                    '@OA\Response' => [
                        'response' => '200',
                        'description' => 'Éxito'
                    ],
                    '@OA\Response' => [
                        'response' => '404',
                        'description' => 'No hay usuarios encontrados'
                    ],
                    '@OA\Response' => [
                        'response' => '500',
                        'description' => 'Error interno del servidor'
                    ]
                ]
            ]
        ],
        '/api/user/getAllPaginated' => [
            'get' => [
                '@OA\Get' => [
                    'summary' => 'Obtener usuarios paginados',
                    'description' => 'Retorna una lista paginada de usuarios con información de paginación',
                    'tags' => ['User'],
                    '@OA\Parameter' => [
                        'name' => 'perPage',
                        'in' => 'query',
                        'required' => false,
                        'description' => 'Número de items por página',
                        '@OA\Schema' => [
                            'type' => 'integer',
                            'default' => 10
                        ]
                    ],
                    '@OA\Parameter' => [
                        'name' => 'page',
                        'in' => 'query',
                        'required' => false,
                        'description' => 'Número de la página actual',
                        '@OA\Schema' => [
                            'type' => 'integer',
                            'default' => 1
                        ]
                    ],
                    '@OA\Parameter' => [
                        'name' => 'details',
                        'in' => 'query',
                        'required' => false,
                        'description' => 'Indica si se desea mostrar detalles de paginación',
                        '@OA\Schema' => [
                            'type' => 'boolean',
                            'default' => false
                        ]
                    ],
                    '@OA\Response' => [
                        'response' => '200',
                        'description' => 'Éxito',
                        'content' => [
                            '@OA\MediaType' => [
                                'mediaType' => 'application/json',
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'items' => [
                                            'type' => 'array',
                                            'items' => [
                                                '@OA\Items' => [
                                                    'ref' => '#/components/schemas/User'
                                                ]
                                            ]
                                        ],
                                        'pagination' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'currentPage' => ['type' => 'integer'],
                                                'totalPages' => ['type' => 'integer'],
                                                'itemsPerPage' => ['type' => 'integer'],
                                                'totalItems' => ['type' => 'integer']
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '@OA\Response' => [
                        'response' => '400',
                        'description' => 'Error de validación',
                        'content' => [
                            '@OA\MediaType' => [
                                'mediaType' => 'application/json',
                                'schema' => [
                                    'type' => 'object'
                                ]
                            ]
                        ]
                    ],
                    '@OA\Response' => [
                        'response' => '500',
                        'description' => 'Error interno del servidor',
                        'content' => [
                            '@OA\MediaType' => [
                                'mediaType' => 'application/json',
                                'schema' => [
                                    'type' => 'object'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        '/api/user/register' => [
            'post' => [
                '@OA\Post' => [
                    'summary' => 'Register new user',
                    'description' => 'Creates a new user account.',
                    'tags' => ['User'],
                    '@OA\RequestBody' => [
                        'required' => true,
                        '@OA\JsonContent' => [
                            'type' => 'object',
                            '@OA\Property' => [
                                'property' => 'nombre',
                                'type' => 'string',
                                'description' => 'Nombre'
                            ],
                            '@OA\Property' => [
                                'property' => 'apellido',
                                'type' => 'string',
                                'description' => 'Apellido'
                            ],
                            '@OA\Property' => [
                                'property' => 'cedula',
                                'type' => 'integer',
                                'description' => 'Número de cédula'
                            ],
                            '@OA\Property' => [
                                'property' => 'telefono',
                                'type' => 'string',
                                'description' => 'Teléfono'
                            ],
                            '@OA\Property' => [
                                'property' => 'email',
                                'type' => 'string',
                                'description' => 'Correo electrónico'
                            ],
                            '@OA\Property' => [
                                'property' => 'user_password',
                                'type' => 'string',
                                'description' => 'Contraseña'
                            ],
                            '@OA\Property' => [
                                'property' => 'rol',
                                'type' => 'string',
                                'description' => 'Rol del usuario'
                            ],
                            '@OA\Property' => [
                                'property' => 'token',
                                'type' => 'string',
                                'description' => 'Indentificador de Usuario'
                            ]
                        ]
                    ],
                    '@OA\Response' => [
                        'response' => '200',
                        'description' => 'Usuario creado exitosamente'
                    ],
                    '@OA\Response' => [
                        'response' => '400',
                        'description' => 'Error de validación'
                    ],
                    '@OA\Response' => [
                        'response' => '409',
                        'description' => 'Email ya registrado'
                    ],
                    '@OA\Response' => [
                        'response' => '500',
                        'description' => 'Error interno del servidor'
                    ]
                ]
            ]
        ]
    ],
    'components' => [
        'schemas' => [
            'User' => [
                'type' => 'object',
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'nombre' => ['type' => 'string'],
                    'apellido' => ['type' => 'string'],
                    'cedula' => ['type' => 'integer'],
                    'phone' => ['type' => 'string'],
                    'email' => ['type' => 'string'],
                    'user_password' => ['type' => 'string'],
                    'rol' => ['type' => 'string'],
                    'token' => ['type' => 'string']
                ]
            ]
        ]
    ]
];
