<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use Illuminate\Support\Facades\Gate;
use FaithGen\News\Policies\NewsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
           News::class => NewsPolicy::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //news gates
        Gate::define('news.create', [NewsPolicy::class, 'create']);
        Gate::define('news.update', [NewsPolicy::class, 'update']);
        Gate::define('news.delete', [NewsPolicy::class, 'delete']);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
