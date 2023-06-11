<?php

use SevenUte\Directavel\Directavel;
use SevenUte\Directavel\Facades\Directavel as DirectavelFacade;

test('table should not be wiped unless set as such in config', function () {
    
    DB::table('directus_activity')
        ->insert([
            'id' => null,
            'action' => 'dummy',
            'timestamp' => now()->timestamp,
            'collection' => 'dummy',
            'item' => 'dummy',
        ]);
    expect(config('directavel.wipe.activity'))->toBeFalse();
    
    $instance = new Directavel();
    $instance->synchronizeDatabase();

    $nb_rows = DB::table('directus_activity')->count();
    expect($nb_rows)->toEqual(1);

    config()->set('directavel.wipe.activity', true);

    $wiped_instance = new Directavel();
    $wiped_instance->synchronizeDatabase();

    $nb_rows = DB::table('directus_activity')->count();
    expect($nb_rows)->toEqual(0);
});


test('collections should sync', function () {

    $nb_collections = DB::table('directus_collections')->count();
    $nb_fields = DB::table('directus_fields')->count();
    $nb_relations = DB::table('directus_fields')->count();
    expect([$nb_collections, $nb_fields, $nb_relations])->each->toEqual(0);

    $instance = new Directavel();
    $instance->synchronizeDatabase();

    $collections = DB::table('directus_collections')->get();
    expect($collections[0]->icon)->toBeNull();
    expect($collections[1]->icon)->not->toBeNull();

    $fields = DB::table('directus_fields')->get();
    expect($fields)
        ->sequence(
            fn ($row) => $row->toHaveProperties(['field' => 'without_properties', 'collection' => 'no-attributes', 'interface' => 'input']),
            fn ($row) => $row->toHaveProperties(['field' => 'without_type', 'collection' => 'with-attributes', 'interface' => 'input']),
            fn ($row) => $row->toHaveProperties(['field' => 'with_type', 'interface' => 'datetime']),
            fn ($row) => $row->toHaveProperties(['field' => 'with_type_property', 'interface' => 'boolean']),
            fn ($row) => $row->toHaveProperties(['field' => 'with_relations', 'interface' => 'input']),
        );

    $relations = DB::table('directus_relations')->get();
     expect($relations)
        ->sequence(
            fn ($row) => $row->toHaveProperties(['many_collection' => 'with-attributes', 'many_field' => 'dummy-attribute-relation-field']),
            fn ($row) => $row->toHaveProperties(['many_collection' => 'with-relations', 'many_field' => 'dummy-relation-field']),
        );
});
