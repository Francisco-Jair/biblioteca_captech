<?php namespace Rupertlustosa\Rlustosa;

use Illuminate\Support\ServiceProvider;

class RlustosaServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        require base_path() . '/vendor/autoload.php';

        $this->bootstrapConfigs();
        $this->bootstrapControllers();
        $this->bootstrapHelpers();
        $this->bootstrapMigrations();
        $this->bootstrapModels();
        $this->bootstrapObservers();
        $this->bootstrapPresenters();
        $this->bootstrapProviders();
        $this->bootstrapPublic();
        $this->bootstrapRepositories();
        $this->bootstrapRequests();
        $this->bootstrapSeeds();
        $this->bootstrapServices();
        $this->bootstrapTraits();
        $this->bootstrapValidators();
        $this->bootstrapViewComposers();
        $this->bootstrapViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResources();

        $this->app['rlustosa'] = $this->app->share(function ($app) {
            return new Rlustosa;
        });
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Rlustosa', 'Rupertlustosa\Rlustosa\Facades\Rlustosa');
        });

        $this->app['command.rlustosa'] = $this->app->share(function ($app) {
            return new RlustosaCommand;
        });
        $this->commands('command.rlustosa');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('rlustosa');
    }

    /**
     * Register the package resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $userConfigFile = app()->configPath() . '/rlustosa.php';
        $packageConfigFile = __DIR__ . '/../../config/config.php';
        $config = $this->app['files']->getRequire($packageConfigFile);

        if (file_exists($userConfigFile)) {
            $userConfig = $this->app['files']->getRequire($userConfigFile);
            $config = array_replace_recursive($config, $userConfig);
        }

        $this->app['config']->set('rlustosa::config', $config);
    }

    /**
     * Load and publishes configs.
     */
    protected function bootstrapConfigs()
    {
        /*$configFile = realpath(__DIR__ . '/../../config/config/.rlustosa');
        $this->publishes([$configFile => $this->app['path.config'] . '/.rlustosa'], 'config');*/

        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/config');
        $path = $this->app['path.base'] . '/config';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapControllers()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Controllers');
        $path = $this->app['path.base'] . '/app/Http/Controllers';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapHelpers()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Helpers');
        $path = $this->app['path.base'] . '/app/Helpers';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapMigrations()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/migrations');
        $path = $this->app['path.base'] . '/database/migrations';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapModels()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Models');
        $path = $this->app['path.base'] . '/app/Models';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapObservers()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Observers');
        $path = $this->app['path.base'] . '/app/Observers';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);

    }

    protected function bootstrapPresenters()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Presenters');
        $path = $this->app['path.base'] . '/app/Presenters';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapProviders()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Providers');
        $path = $this->app['path.base'] . '/app/Providers';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapPublic()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/public');
        $path = $this->app['path.base'] . '/public';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapRepositories()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Repositories');
        $path = $this->app['path.base'] . '/app/Repositories';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapRequests()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Requests');
        $path = $this->app['path.base'] . '/app/Http/Requests';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapSeeds()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/seeds');
        $path = $this->app['path.base'] . '/database/seeds';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapServices()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Services');
        $path = $this->app['path.base'] . '/app/Services';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapTraits()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Traits');
        $path = $this->app['path.base'] . '/app/Traits';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapValidators()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/Validators');
        $path = $this->app['path.base'] . '/app/Validators';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapViewComposers()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/ViewComposers');
        $path = $this->app['path.base'] . '/app/Http/ViewComposers';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }

    protected function bootstrapViews()
    {
        $listFile = [];

        $configFile = realpath(__DIR__ . '/../../config/views');
        $path = $this->app['path.base'] . '/resources/views';

        $files = \File::allFiles($configFile);

        foreach ($files as $file) {
            $listFile = array_merge($listFile, [(string)$file => $path . str_replace($configFile, '', $file)]);
        }
        $this->publishes($listFile);
    }
}