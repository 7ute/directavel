<?php

namespace SevenUte\Directavel\Models;

use Illuminate\Database\Eloquent\Model;

class DirectusPresets extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'bookmark',
        'user',
        'role',
        'collection',
        'search',
        'layout',
        'layout_query',
        'layout_options',
        'refresh_interval',
        'filter',
        'icon',
        'color',
    ];

    protected $casts = [
        'layout_query' => 'json',
        'layout_options' => 'json',
        'filter' => 'json',
    ];
}
