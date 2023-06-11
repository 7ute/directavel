<?php

namespace SevenUte\Directavel\Models;

use Illuminate\Database\Eloquent\Model;

class DirectusCollections extends Model
{
    protected $primaryKey = 'collection';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'collection',
        'icon',
        'note',
        'display_template',
        'hidden',
        'singleton',
        'translations',
        'archive_field',
        'archive_app_filter',
        'archive_value',
        'unarchive_value',
        'sort_field',
        'accountability',
        'color',
        'item_duplication_fields',
        'sort',
        'group',
        'collapse',
        'preview_url',
    ];

    protected $casts = [
        'hidden' => 'boolean',
        'singleton' => 'boolean',
        'archive_app_filter' => 'boolean',
        'translations' => 'json',
        'item_duplication_fields' => 'json',
    ];
}
