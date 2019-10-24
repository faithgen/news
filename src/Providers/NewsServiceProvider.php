<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use FaithGen\News\Observers\Ministry\NewsObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../storage/news/' => storage_path('app/public/news')
            ], 'faithgen-news-storage');
        }

        News::observe(NewsObserver::class);
    }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/news.php');
        });
    }
    private function routeConfiguration()
    {
        return [
            'prefix' => config('faithgen-news.prefix') ? config('faithgen-news.prefix') : 'api',
            'namespace' => "FaithGen\News\Http\Controllers",
            'middleware' => ['auth:api', 'ministry.activated'],
        ];
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
