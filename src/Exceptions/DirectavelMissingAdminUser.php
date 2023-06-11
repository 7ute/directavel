<?php

namespace SevenUte\Directavel\Exceptions;

use Exception;

class DirectavelMissingAdminUser extends Exception
{
    public function __construct()
    {
        parent::__construct('The directus_users table does not contain any user with the email set in the directavel.admin_user config entry. Make sure you ran directus bootstraping and migrations commands.');
    }
}
