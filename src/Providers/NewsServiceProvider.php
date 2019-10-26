<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use FaithGen\News\Observers\Ministry\NewsObserver;
use FaithGen\SDK\Traits\ConfigTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    use ConfigTrait;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-news.php', 'faithgen-news');
        $this->registerRoutes(__DIR__ . '/../routes/news.php', __DIR__ . '/../routes/source.php');

        $this->setUpFiles(function () {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../storage/news/' => storage_path('app/public/news')
            ], 'faithgen-news-storage');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations')
            ], 'faithgen-news-migrations');
        });

        $this->publishes([
            __DIR__ . '/../config/faithgen-news.php' => config_path('faithgen-news.php')
        ], 'faithgen-news-config');

        News::observe(NewsObserver::class);
    }

    public function register()
    {

    }

    /**
     * The config you want to be applied onto your routes
     * @return array the rules eg, middleware, prefix, namespace
     */
    function routeConfiguration(): array
    {
        return [
            'prefix' => config('faithgen-news.prefix'),
            'namespace' => "FaithGen\News\Http\Controllers",
            'middleware' => config('faithgen-news.middlewares'),
        ];
    }
}
