<?php

namespace App\Policies;

use App\Models\ArtistPolicy;
use App\Models\User;
use App\Policies\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArtistProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArtistPolicy  $artistPolicy
     * @return mixed
     */
    public function view(User $user, ArtistPolicy $artistPolicy)
    {
        return $user->id === $artistPolicy->$user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin === 1;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArtistPolicy  $artistPolicy
     * @return mixed
     */
    public function update(User $user, ArtistProfile $artist)
    {
        return $user->id === $artist->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArtistPolicy  $artistPolicy
     * @return mixed
     */
    public function delete(User $user, ArtistPolicy $artistPolicy)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArtistPolicy  $artistPolicy
     * @return mixed
     */
    public function restore(User $user, ArtistPolicy $artistPolicy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArtistPolicy  $artistPolicy
     * @return mixed
     */
    public function forceDelete(User $user, ArtistPolicy $artistPolicy)
    {
        //
    }
}
