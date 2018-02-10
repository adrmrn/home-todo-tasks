<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => 'Api\\V1\\Rpc\\Health\\HealthControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api.rpc.health' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/health',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rpc\\Health\\Controller',
                        'action' => 'health',
                    ),
                ),
            ),
            'api.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'api.rest.authentication' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/authentication[/:authentication_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\Authentication\\Controller',
                    ),
                ),
            ),
            'api.rest.group' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/group[/:group_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\Group\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rpc.health',
            1 => 'api.rest.user',
            2 => 'api.rest.authentication',
            3 => 'api.rest.group',
        ),
    ),
    'zf-rpc' => array(
        'Api\\V1\\Rpc\\Health\\Controller' => array(
            'service_name' => 'Health',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'api.rpc.health',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => 'Json',
            'Api\\V1\\Rest\\User\\Controller' => 'HalJson',
            'Api\\V1\\Rest\\Authentication\\Controller' => 'HalJson',
            'Api\\V1\\Rest\\Group\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Api\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
                3 => 'application/vnd.api.v1+json',
                4 => 'application/hal+json',
                5 => 'application/json',
            ),
            'Api\\V1\\Rest\\Authentication\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Api\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'Api\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/vnd.api.v1+json',
                3 => 'application/json',
            ),
            'Api\\V1\\Rest\\Authentication\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'Api\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Api\\V1\\Rest\\User\\UserResource' => 'Api\\V1\\Rest\\User\\UserResourceFactory',
            'Api\\V1\\Rest\\Authentication\\AuthenticationResource' => 'Api\\V1\\Rest\\Authentication\\AuthenticationResourceFactory',
            'Api\\V1\\Rest\\Group\\GroupResource' => 'Api\\V1\\Rest\\Group\\GroupResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'Api\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\User\\UserResource',
            'route_name' => 'api.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'GET',
                5 => 'PUT',
                6 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'GET',
                3 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'name',
                1 => 'email',
                2 => 'sort_by',
                3 => 'sort_direction',
            ),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'Api\\V1\\Rest\\User\\UserEntity',
            'collection_class' => 'Api\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
        'Api\\V1\\Rest\\Authentication\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\Authentication\\AuthenticationResource',
            'route_name' => 'api.rest.authentication',
            'route_identifier_name' => 'authentication_id',
            'collection_name' => 'authentication',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Api\\V1\\Rest\\Authentication\\AuthenticationEntity',
            'collection_class' => 'Api\\V1\\Rest\\Authentication\\AuthenticationCollection',
            'service_name' => 'Authentication',
        ),
        'Api\\V1\\Rest\\Group\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\Group\\GroupResource',
            'route_name' => 'api.rest.group',
            'route_identifier_name' => 'group_id',
            'collection_name' => 'group',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'name',
                1 => 'sort_by',
                2 => 'sort_direction',
            ),
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => 'Api\\V1\\Rest\\Group\\GroupEntity',
            'collection_class' => 'Api\\V1\\Rest\\Group\\GroupCollection',
            'service_name' => 'Group',
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Api\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Api\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
            'Api\\V1\\Rest\\Authentication\\AuthenticationEntity' => array(
                'entity_identifier_name' => 'token',
                'route_name' => 'api.rest.authentication',
                'route_identifier_name' => 'authentication_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Api\\V1\\Rest\\Authentication\\AuthenticationCollection' => array(
                'entity_identifier_name' => 'token',
                'route_name' => 'api.rest.authentication',
                'route_identifier_name' => 'authentication_id',
                'is_collection' => true,
            ),
            'Api\\V1\\Rest\\Group\\GroupEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.group',
                'route_identifier_name' => 'group_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Api\\V1\\Rest\\Group\\GroupCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.group',
                'route_identifier_name' => 'group_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Api\\V1\\Rest\\User\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'Api\\V1\\Rest\\Authentication\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'Api\\V1\\Rest\\Group\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
);
