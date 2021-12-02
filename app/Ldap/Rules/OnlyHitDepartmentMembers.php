<?php

namespace App\Ldap\Rules;

use Illuminate\Support\Facades\Log;
use LdapRecord\Laravel\Auth\Rule;
use LdapRecord\Models\ActiveDirectory\Group;

class OnlyHitDepartmentMembers extends Rule
{
    /**
     * Check if the rule passes validation.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $schuelerHIT = Group::find('CN=schuelerHIT,OU=Groups,OU=tgm,DC=tgm,DC=ac,DC=at');
        $lehrerHIT = Group::find('CN=lehrerHIT,OU=Groups,OU=tgm,DC=tgm,DC=ac,DC=at');

        return
            $this->user->groups()->recursive()->exists($schuelerHIT) ||
            $this->user->groups()->recursive()->exists($lehrerHIT);
    }
}
