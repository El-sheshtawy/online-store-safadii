<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model'   => 'App\Policies\ModelPolicy',

        // 'App\Models\Product' => 'App\Policies\ProductPolicy',

        //or Generic Policy
        // 'App\Models\Category'  => 'App\Policies\ModelPolicy',
        // 'App\Models\Product'   => 'App\Policies\ModelPolicy',
        // 'App\Models\Role'      => 'App\Policies\ModelPolicy',
    ];

    public function register()
    {
        parent::register();
        $this->app->bind('abilities', fn () => include base_path('role_abilities/abilities.php'));
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function () {
            $admin = Auth::guard('admin')->user();
           if ($admin->super_admin == 1) {
               return true;
            }
        });

       foreach ($this->app->make('abilities') as $name => $description) {
          Gate::define($name, function (Admin $admin) use ($name) {
               return $admin->hasAbility($name);
           });
       }
    }
}
