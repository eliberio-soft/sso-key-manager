<?php

namespace Eliberiosoft\SsoKeyManager;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SsoKeyManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configArray = include __DIR__.'/../resources/config.php';
        Config::set('database.connections', array_merge(Config::get('database.connections'), [$configArray['connection'] => $configArray['config']]));
        Config::set('database.sso_manager', ['app-id'=>$configArray['app-id'],'table' => $configArray['table'], 'connection' => 
$configArray['connection']]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\SsoKeyManagerInstall::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
