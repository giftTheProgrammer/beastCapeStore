<?php

namespace App\Policies;


use App\Models\Manager;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManagerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    public function index(User $user){
        return $user->role_id === 1;
    }

    public function setStatus(User $user){
        return $user->role_id === 1;
    }
}
