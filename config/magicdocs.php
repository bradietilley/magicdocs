<?php

return [
    'directories' => [
        'app/Models' => [
            'type' => 'model',
            'parsers' => [
                \MagicDocs\Parsers\Laravel\AccessorsAsProperties::class => true,
                \MagicDocs\Parsers\Laravel\ColumnsAsProperties::class => true,
                \MagicDocs\Parsers\Laravel\CastsAsProperties::class => true,
                \MagicDocs\Parsers\Laravel\ModelHasFactoryReturnsFactoryClass::class => true,
                \MagicDocs\Parsers\Laravel\RelationsAsProperties::class => true,
                \MagicDocs\Parsers\Laravel\ScopesAsMethods::class => true,
            ],
        ],

        'app/Providers' => [
            'type' => 'provider',
            'parsers' => [
                \MagicDocs\Parsers\Laravel\MacrosAsMethods::class => true,
            ],
        ],

        'app/Http/Requests' => [
            'type' => 'request',
            'parsers' => [
                \MagicDocs\Parsers\Laravel\RequestParametersAsProperties::class => true,
            ]
        ],

        'app/Nova' => [
            'type' => 'resource',
            'parsers' => [
                \MagicDocs\Parsers\Laravel\NovaResourceWithModelProperties::class => true,
            ],
        ],
    ],

    'standalones' => [
        \MagicDocs\Parsers\Laravel\ModelsExposeQueryBuilderMethods::class => true,
        \MagicDocs\Parsers\Laravel\FixUserModelResolvers::class => [
            [
                'request' => 'Illuminate\Http\Request',
            ],
            [
                'request' => 'Illuminate\Support\Facades\Auth',
                'static' => true,
            ],
            [
                'request' => 'Illuminate\Support\Facades\Request',
                'static' => true,
            ],
        ],
    ],

    'output' => 'bootstrap/magicdocs.php',
];