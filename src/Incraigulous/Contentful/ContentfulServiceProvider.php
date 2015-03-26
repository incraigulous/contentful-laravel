<?php namespace Incraigulous\Contentful;

use Illuminate\Support\ServiceProvider;
use Incraigulous\Contentful\Facades\Contentful;
use \Config as Config;

class ContentfulServiceProvider extends ServiceProvider {

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
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('contentful.php'),
        ]);
		//$this->package('incraigulous/contentful');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['contentful'] = $this->app->share(function($app)
		{
            return new DeliveryClient(config('contentful.space'), config('contentful.token'));
		});
        $this->app['contentfulManagement'] = $this->app->share(function($app)
        {
            return new ManagementClient(config('contentful.space'), config('contentful.oauthToken'));
        });
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Contentful','Incraigulous\Contentful\Facades\Contentful');
            $loader->alias('ContentfulManagement','Incraigulous\Contentful\Facades\ContentfulManagement');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('contenful');
	}

}
