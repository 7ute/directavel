<?php

return [
    [
        'bookmark' => null,
        'collection' => 'directus_activity',
        'layout' => 'tabular',
        'layout_query' => '{"tabular": {"sort": ["-timestamp"], "limit": 25, "fields": ["action", "collection", "timestamp", "user"]}}',
        'layout_options' => '{"tabular": {"widths": {"user": 240, "action": 100, "timestamp": 240, "collection": 210}}}',
        'icon' => 'bookmark',
    ],
    [
        'bookmark' => null,
        'collection' => 'directus_presets',
        'layout' => null,
        'layout_query' => '{"tabular": {"sort": ["id"], "limit": 25, "fields": ["id", "collection", "user", "bookmark", "role"]}}',
        'layout_options' => '{"tabular": {"widths": {"id": 94}}}',
        'icon' => 'bookmark',
    ],
    [
        'bookmark' => null,
        'collection' => 'directus_users',
        'layout' => 'cards',
        'layout_query' => '{"cards": {"sort": ["email"], "limit": 25}}',
        'layout_options' => '{"cards": {"icon": "account_circle", "size": 4, "title": "{{ first_name }} {{ last_name }}", "subtitle": "{{ email }}"}}',
        'icon' => 'bookmark',
    ],
];
