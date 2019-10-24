<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use FaithGen\News\Policies\NewsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('news.create', '\FaithGen\News\Policies\NewsPolicy@create');
        Gate::define('news.update', '\FaithGen\News\Policies\NewsPolicy@update');
        Gate::define('news.delete', '\FaithGen\News\Policies\NewsPolicy@delete');
        Gate::define('news.view', '\FaithGen\News\Policies\NewsPolicy@view');

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
