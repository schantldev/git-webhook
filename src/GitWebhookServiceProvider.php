<?php

namespace SchantlDev\GitWebhook;

use Illuminate\Support\ServiceProvider;
use SchantlDev\GitWebhook\Commands\DefaultGithubDeploy;
use Symfony\Component\Process\Process;

class GitWebhookServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('git-webhook.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../storage/deploy_stub.sh' => storage_path('git-webhook/git_deploy.sh'),
            ], 'scripts');
        }

        // Registering package commands.
        $this->commands([DefaultGithubDeploy::class]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'git-webhook');
    }
}
