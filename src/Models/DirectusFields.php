<?php

namespace SevenUte\Directavel\Models;

use Illuminate\Database\Eloquent\Model;

class DirectusFields extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'collection',
        'field',
        'special',
        'interface',
        'options',
        'display',
        'display_options',
        'readonly',
        'hidden',
        'sort',
        'width',
        'translations',
        'note',
        'conditions',
        'required',
        'group',
        'validation',
        'validation_message',
    ];

    protected $casts = [
        'options' => 'json',
        'display_options' => 'json',
        'translations' => 'json',
        'conditions' => 'json',
        'validation' => 'json',
        'readonly' => 'boolean',
        'hidden' => 'boolean',
        'required' => 'boolean',
    ];

    public static function interfaceFromType($type = null)
    {
        return match ($type) {
            'timestamp', 'dateTime', 'time', 'date' => 'datetime',
            'text', 'mediumText', 'smallText', 'bigText' => 'input-multiline',
            'tinyInt', 'boolean' => 'boolean',
            default => 'input',
        };
    }

    const WIDTH_FULL = 'full';
    const WIDTH_HALF = 'half';

    const INTERFACE_BOOLEAN = 'boolean';
    const INTERFACE_COLLECTION_ITEM_DROPDOWN = 'collection-item-dropdown';
    const INTERFACE_DATETIME = 'datetime';
    const INTERFACE_FILE_IMAGE = 'file-image';
    const INTERFACE_FILE = 'file';
    const INTERFACE_FILES = 'files';
    const INTERFACE_GROUP_ACCORDION = 'group-accordion';
    const INTERFACE_GROUP_DETAIL = 'group-detail';
    const INTERFACE_GROUP_RAW = 'group-raw';
    const INTERFACE_INPUT_AUTOCOMPLETE_API = 'input-autocomplete-api';
    const INTERFACE_INPUT_BLOCK_EDITOR = 'input-block-editor';
    const INTERFACE_INPUT_CODE = 'input-code';
    const INTERFACE_INPUT_HASH = 'input-hash';
    const INTERFACE_INPUT_MULTILINE = 'input-multiline';
    const INTERFACE_INPUT_RICH_TEXT_HTML = 'input-rich-text-html';
    const INTERFACE_INPUT_RICH_TEXT_MD = 'input-rich-text-md';
    const INTERFACE_INPUT = 'input';
    const INTERFACE_LIST_M2A = 'list-m2a';
    const INTERFACE_LIST_M2M = 'list-m2m';
    const INTERFACE_LIST_O2M_TREE_VIEW = 'list-o2m-tree-view';
    const INTERFACE_LIST_O2M = 'list-o2m';
    const INTERFACE_LIST = 'list';
    const INTERFACE_MAP = 'map';
    const INTERFACE_PRESENTATION_DIVIDER = 'presentation-divider';
    const INTERFACE_PRESENTATION_LINKS = 'presentation-links';
    const INTERFACE_PRESENTATION_NOTICE = 'presentation-notice';
    const INTERFACE_SELECT_COLOR = 'select-color';
    const INTERFACE_SELECT_DROPDOWN_M2O = 'select-dropdown-m2o';
    const INTERFACE_SELECT_DROPDOWN = 'select-dropdown';
    const INTERFACE_SELECT_ICON = 'select-icon';
    const INTERFACE_SELECT_MULTIPLE_CHECKBOX_TREE = 'select-multiple-checkbox-tree';
    const INTERFACE_SELECT_MULTIPLE_CHECKBOX = 'select-multiple-checkbox';
    const INTERFACE_SELECT_MULTIPLE_DROPDOWN = 'select-multiple-dropdown';
    const INTERFACE_SELECT_RADIO = 'select-radio';
    const INTERFACE_SLIDER = 'slider';
    const INTERFACE_TAGS = 'tags';
    const INTERFACE_TRANSLATIONS = 'translations';

    const SPECIAL_HASH = 'hash';
    const SPECIAL_UUID = 'uuid';
    const SPECIAL_CAST_BOOLEAN = 'cast-boolean';
    const SPECIAL_CAST_JSON = 'cast-json';
    const SPECIAL_CONCEAL = 'conceal';
    const SPECIAL_USER_CREATED = 'user-created';
    const SPECIAL_USER_UPDATED = 'user-updated';
    const SPECIAL_ROLE_CREATED = 'role-created';
    const SPECIAL_ROLE_UPDATED = 'role-updated';
    const SPECIAL_DATE_CREATED = 'date-created';
    const SPECIAL_DATE_UPDATED = 'date-updated';
    const SPECIAL_CAST_CSV = 'cast-csv';
    const SPECIAL_M2M = 'm2m';
    const SPECIAL_O2M = 'o2m';

    public static $interfaces = [
        self::INTERFACE_BOOLEAN,
        self::INTERFACE_COLLECTION_ITEM_DROPDOWN,
        self::INTERFACE_DATETIME,
        self::INTERFACE_FILE_IMAGE,
        self::INTERFACE_FILE,
        self::INTERFACE_FILES,
        self::INTERFACE_GROUP_ACCORDION,
        self::INTERFACE_GROUP_DETAIL,
        self::INTERFACE_GROUP_RAW,
        self::INTERFACE_INPUT_AUTOCOMPLETE_API,
        self::INTERFACE_INPUT_BLOCK_EDITOR,
        self::INTERFACE_INPUT_CODE,
        self::INTERFACE_INPUT_HASH,
        self::INTERFACE_INPUT_MULTILINE,
        self::INTERFACE_INPUT_RICH_TEXT_HTML,
        self::INTERFACE_INPUT_RICH_TEXT_MD,
        self::INTERFACE_INPUT,
        self::INTERFACE_LIST_M2A,
        self::INTERFACE_LIST_M2M,
        self::INTERFACE_LIST_O2M_TREE_VIEW,
        self::INTERFACE_LIST_O2M,
        self::INTERFACE_LIST,
        self::INTERFACE_MAP,
        self::INTERFACE_PRESENTATION_DIVIDER,
        self::INTERFACE_PRESENTATION_LINKS,
        self::INTERFACE_PRESENTATION_NOTICE,
        self::INTERFACE_SELECT_COLOR,
        self::INTERFACE_SELECT_DROPDOWN_M2O,
        self::INTERFACE_SELECT_DROPDOWN,
        self::INTERFACE_SELECT_ICON,
        self::INTERFACE_SELECT_MULTIPLE_CHECKBOX_TREE,
        self::INTERFACE_SELECT_MULTIPLE_CHECKBOX,
        self::INTERFACE_SELECT_MULTIPLE_DROPDOWN,
        self::INTERFACE_SELECT_RADIO,
        self::INTERFACE_SLIDER,
        self::INTERFACE_TAGS,
        self::INTERFACE_TRANSLATIONS,
    ];

    public static $specials = [
        self::SPECIAL_HASH,
        self::SPECIAL_UUID,
        self::SPECIAL_CAST_BOOLEAN,
        self::SPECIAL_CAST_JSON,
        self::SPECIAL_CONCEAL,
        self::SPECIAL_USER_CREATED,
        self::SPECIAL_USER_UPDATED,
        self::SPECIAL_ROLE_CREATED,
        self::SPECIAL_ROLE_UPDATED,
        self::SPECIAL_DATE_CREATED,
        self::SPECIAL_DATE_UPDATED,
        self::SPECIAL_CAST_CSV,
        self::SPECIAL_M2M,
        self::SPECIAL_O2M,
    ];
}
