<?php

namespace SevenUte\Directavel\Exceptions;

use Exception;

class DirectavelStorageMissingException extends Exception
{
    public function __construct()
    {
        parent::__construct('The filesystem used by Directus is not defined. Please check the "directus.filesystem" config.');
    }
}
