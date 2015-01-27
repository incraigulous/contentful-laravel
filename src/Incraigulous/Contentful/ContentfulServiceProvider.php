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
		$this->package('incraigulous/contentful');
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
			return new Client(Config::get('contentful::space'), Config::get('contentful::token'));
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Contentful','Incraigulous\Contentful\Facades\Contentful');
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
