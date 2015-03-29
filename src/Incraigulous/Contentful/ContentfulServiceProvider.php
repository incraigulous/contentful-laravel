<?php namespace Incraigulous\Contentful;

use Illuminate\Support\ServiceProvider;
use Incraigulous\Contentful\Console\Commands\CreateWebhook;
use Incraigulous\Contentful\Console\Commands\Listen;
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
        include __DIR__.'/../../routes.php';

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('contentful.php'),
        ]);

        $this->commands(['contenful:create-webhook', 'contenful:listen']);

        $this->app['contenful:create-webhook'] = $this->app->share(function($app)
        {
            return new CreateWebhook;
        });

        $this->app['contenful:listen'] = $this->app->share(function($app)
        {
            return new Listen;
        });
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
