<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Pktharindu\NovaPermissions\Traits\ValidatesPermissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use ValidatesPermissions;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        '\Pktharindu\NovaPermissions\Nova\Role' => 'App\Policies\RolePolicy',
        'App\Models\Periodic' => 'App\Policies\PeriodicPolicy',
        'App\Models\Book' => 'App\Policies\BookPolicy',
        'App\Models\Series' => 'App\Policies\SeriesPolicy',
        'App\Models\Tag' => 'App\Policies\TagPolicy',
        'App\Models\Topic' => 'App\Policies\TopicPolicy',
        'App\Models\Subtopic' => 'App\Policies\SubtopicPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach (config('nova-permissions.permissions') as $key => $permissions) {
            Gate::define($key, function (User $user) use ($key) {
                if ($this->nobodyHasAccess($key)) {
                    return true;
                }

                return $user->hasPermissionTo($key);
            });
        }
    }
}
