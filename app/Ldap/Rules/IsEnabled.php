<?php

namespace App\Ldap\Rules;

use LdapRecord\Laravel\Auth\Rule;

class IsEnabled extends Rule
{
    /**
     * Check if the rule passes validation.
     *
     * @return bool
     */
    public function isValid()
    {
        return isset($this->model->enabled) ? $this->model->enabled : true;
    }
}
