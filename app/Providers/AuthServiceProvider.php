<?php

namespace App\Providers;

use App\Policies\ArtistProfilePolicy;
use App\Policies\ManagerPolicy;
use App\Models\ArtistProfile;
use App\Models\Artwork;
use App\Models\Manager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ArtistProfile::class => ArtistProfilePolicy::class,
        Artwork::class => ArtworkPolicy::class,
        Manager::class => ManagerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('admin-only', function($user){
            if ($user->is_admin == 1) {
                return true;
            }
            return false;
        });

        Gate::define('buyers-only', function(User $user){
            if (optional($user)->role_id == 0) {
                return true;
            }
            return false;
        });

        Gate::define('artform-create', 'App\Policies\ArtworkPolicy@create');
        Gate::define('view-music', 'App\Policies\ArtworkPolicy@musicView');

        Gate::resource('ArtistProfiles', 'ArtistProfilePolicy');

        Gate::define('user_role', 'App\Policies\ManagerPolicy@index');
        Gate::define('approve', 'App\Policies\ManagerPolicy@setStatus');
    }
}
