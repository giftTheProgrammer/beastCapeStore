<?php

namespace App\Providers;

use App\Policies\ArtistProfilePolicy;
use App\Models\ArtistProfile;
use App\Models\Artwork;
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
        'App\Models\Artwork' => ArtworkPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
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

        Gate::define('artform-create', 'App\Policies\ArtworkPolicy@create');

        Gate::resource('ArtistProfiles', 'ArtistProfilePolicy');
    }
}
