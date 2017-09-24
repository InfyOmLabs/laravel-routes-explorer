<?php

namespace InfyOm\RoutesExplorer;

use Illuminate\Support\ServiceProvider;

class RoutesExplorerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/routes_explorer.php';

        $this->publishes([
            $configPath => config_path('infyom/routes_explorer.php'),
        ]);

        $migrationPath = __DIR__ . '/../stubs/migration.stub';
        $fileName = date('Y_m_d_His') . '_' . 'create_api_calls_count_table.php';

        $this->publishes([
            $migrationPath => database_path('migrations/' . $fileName),
        ], 'migrations');

        $viewPath = __DIR__ . '/../views/routes.blade.php';

        $this->publishes([
            $viewPath => resource_path('views/routes/routes.blade.php'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/../views', 'infyomlabs');

        if (config('infyom.routes_explorer.enable_explorer')) {
            $this->app['router']->get(
                config('infyom.routes_explorer.route'),
                "\\InfyOm\\RoutesExplorer\\RoutesExplorer@showRoutes"
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}