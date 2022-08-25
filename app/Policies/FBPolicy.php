<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FB;
use Illuminate\Auth\Access\HandlesAuthorization;

class FBPolicy
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

    public function view_detail(User $user,FB $fb){
        

    }
}
