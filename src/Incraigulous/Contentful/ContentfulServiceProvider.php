<?php namespace Incraigulous\Contentful;

use Illuminate\Support\ServiceProvider;
use \Config as Config;
use Incraigulous\ContentfulSDK\DeliverySDK;
use Incraigulous\ContentfulSDK\ManagementSDK;

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
	}

	/**
	 * Register the service provider. Create Facades for both the Delivery and the Management SDKs.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['contentful'] = $this->app->share(function($app)
		{
            return new DeliverySDK(config('contentful.space'), config('contentful.token'), new Cacher());
		});
        $this->app['contentfulManagement'] = $this->app->share(function($app)
        {
            return new ManagementSDK(config('contentful.space'), config('contentful.oauthToken', new Cacher()));
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
		return array(
            'contenful',
            'contentfulManagement'
        );
	}

}
