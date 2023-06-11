<?php

use SevenUte\Directavel\Models\DirectusFields;

return [
    'attributes' => [
        'display_template' => '{{label}}',
        'hidden' => true,
        'icon' => 'group',
    ],

    'fields' => [
        'id' => [
            'readonly' => true,
            'hidden' => true,
        ],

        /** All fields are considered being INPUT by default */
        'name',

        /** When the content of a field is a string, it's assumed to being its type */
        'onboarded_at' => DirectusFields::INTERFACE_DATETIME,

        /** This will setup the timestamp fields */
        'created_at' => ['interface' => DirectusFields::INTERFACE_DATETIME, 'width' => DirectusFields::WIDTH_HALF],
        'updated_at' => ['interface' => DirectusFields::INTERFACE_DATETIME, 'width' => DirectusFields::WIDTH_HALF],

        'email' => [
            'required' => true,
        ],
        'password' => [
            'options' => [
                'masked' => true,
            ],
        ],

        'is_active' => [
            'special' => DirectusFields::SPECIAL_CAST_BOOLEAN,
            'interface' => DirectusFields::INTERFACE_BOOLEAN,
            'display' => DirectusFields::INTERFACE_BOOLEAN,
        ],

        'user_id' => [
            'interface' => DirectusFields::INTERFACE_SELECT_DROPDOWN_M2O,
            'relation' => ['many_field' => 'user_id', 'one_collection' => 'users'],
        ],

        'country' => [
            'interface' => DirectusFields::INTERFACE_SELECT_DROPDOWN,
            'width' => DirectusFields::WIDTH_HALF,
            'options' => [
                'choices' => [
                    'FR' => 'France',
                    'US' => 'United States of America',
                ],
            ],
        ],

        'coordinates' => [
            'interface' => DirectusFields::INTERFACE_MAP,
            'options' => [
                "defaultView" => [
                    "zoom" => 3.10,
                    "pitch" => 0,
                    "center" => [
                        "lat" => 46.52,
                        "lng" => 1.67,
                    ],
                    "bearing" => 0,
                ],
                "geometryType" => "Point",
            ],
        ],

    ],
];
