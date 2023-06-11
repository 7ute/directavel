<?php

use SevenUte\Directavel\Models\DirectusFields;

test('interface inference should work for dates', function () {
    expect([
        DirectusFields::interfaceFromType('timestamp'),
        DirectusFields::interfaceFromType('dateTime'),
        DirectusFields::interfaceFromType('time'),
        DirectusFields::interfaceFromType('date'),
        ])
        ->each->toEqual('datetime');
});
test('interface inference should work for texts', function () {
    expect([
        DirectusFields::interfaceFromType('text'),
        DirectusFields::interfaceFromType('mediumText'),
        DirectusFields::interfaceFromType('smallText'),
        DirectusFields::interfaceFromType('bigText'),
    ])
    ->each->toEqual('input-multiline');
});
test('interface inference should work for booleans', function () {
    expect([
        DirectusFields::interfaceFromType('tinyInt'),
        DirectusFields::interfaceFromType('boolean'),
    ])
    ->each->toEqual('boolean');
});
test('interface inference should fallback to input for unknown types', function () {
    expect([
        DirectusFields::interfaceFromType(),
        DirectusFields::interfaceFromType('nonExistantFieldType'),
    ])
    ->each->toEqual('input');
});
