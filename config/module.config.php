<?php
return [
    'doctrine' => [
        'driver' => [
            'application_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '../src/Recuento/Entity']
            ],

            'orm_default' => [
                'drivers' => [
                    'Recuento\Entity' => 'application_entities'
                ]
            ]
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'scraper' => [
                    'options' => [
                        'route'    => 'recuento',
                        'defaults' => [
                            'controller' => 'Recuento\Controller\Acta',
                            'action'     => 'read'
                        ]
                    ]
                ]
            ],
        ],
    ],

    'controllers' => array(
        'invokables' => array(
            'Recuento\Controller\Acta' => 'Recuento\Controller\ActaController',
        ),
    ),

    'router' => array(
            'routes' => array(
                    // The following is a route to simplify getting started creating
                    // new controllers and actions without needing to create a new
                    // module. Simply drop new controllers in, and you can access them
                    // using the path /module/:controller/:action
                    'recuento' => array(
                            'type'    => 'Literal',
                            'options' => array(
                                    'route'    => '/recuento',
                                    'defaults' => array(
                                            '__NAMESPACE__' => 'Recuento\Controller',
                                            'controller'    => 'Index',
                                            'action'        => 'index',
                                    ),
                            ),
                            'may_terminate' => true,
                            'child_routes' => array(
                                    'default' => array(
                                            'type'    => 'Segment',
                                            'options' => array(
                                                    'route'    => '/[:controller[/:action[/:id]]]',
                                                    'constraints' => array(
                                                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                    ),
                                                    'defaults' => array(
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
            ),
    ),
];