<?php

namespace montserrat\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use montserrat\Attachment;
use montserrat\User;

class AttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function show_attachment(User $user, Attachment $attachment)
    {
         return false;
    }
    public function show_avatar(User $user)
    {
         return true;
    }
}
