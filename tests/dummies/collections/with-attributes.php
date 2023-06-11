<?php

use SevenUte\Directavel\Models\DirectusFields;

return [
    'attributes' => [
        'display_template' => '{{label}}',
        'icon' => 'dummy',
    ],

    'fields' => [
        'without_type' => [
            'readonly' => true,
            'hidden' => true,
        ],
        'with_type' => DirectusFields::INTERFACE_DATETIME,
        'with_type_property' => [
            'interface' => DirectusFields::INTERFACE_BOOLEAN,
        ],
        'with_relations' => [
            'relation' => ['many_field' => 'dummy-attribute-relation-field'],
        ],
    ],

    'relations' => [
        ['many_collection' => 'with-relations', 'many_field' => 'dummy-relation-field'],
    ],
];
