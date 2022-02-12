<?php

namespace App\Ldap\AttributeHandlers;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class IsAdminHandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database): void
    {
        $database->isAdmin = $database->isAdmin || in_array($database->username, [ 'pdamianik', 'pelias', 'jkammellander', 'szakall']);
    }
}
