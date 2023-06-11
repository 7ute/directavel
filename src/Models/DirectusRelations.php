<?php

namespace SevenUte\Directavel\Models;

use Illuminate\Database\Eloquent\Model;

class DirectusRelations extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'many_collection',
        'many_field',
        'one_collection',
        'one_field',
        'one_collection_field',
        'one_allowed_collections',
        'junction_field',
        'sort_field',
        'one_deselect_action',
    ];

    const RELATIONS_SPECIAL = ['m2o', 'm2m'];
}
