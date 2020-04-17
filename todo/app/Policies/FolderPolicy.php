<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Folder;

class FolderPolicy
{
    use HandlesAuthorization;

//     /**
//      * Create a new policy instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         //
//     }

    public function view(User $user, Folder $folder) {
        return $user->id === $folder->user_id;
    }


}
