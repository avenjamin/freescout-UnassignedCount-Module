<?php

namespace Modules\UnassignedCount\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class UnassignedCountServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->hooks();
    }

	
	public function getNumberOfUnassignedConversationsText($mailbox_item) {
		// Validate $mailbox_item
		if (!$mailbox_item or !$mailbox_item->getFolderByType(1))
			return '';
		
		// Get position setting
		$position = \Option::get('unassignedcount.unassigned_count_position', \Config::get('unassignedcount.unassigned_count_position'));

		// Get the number of unassigned conversations
        $numberOfUnassignedConversations = $mailbox_item->getFolderByType(1)->getCount();
		
		// Return the text if the number of unassigned conversations is greater than 0
		if ($numberOfUnassignedConversations > 0)
			return ($position == 'after' ? ' ' : '').'<b>('.$numberOfUnassignedConversations.')</b>'.($position == 'before' ? ' ' : '');
		
		// Otherwise return an empty string
		return '';
	}

    /**
     * Module hooks.
     */
    public function hooks()
    {
        // Show number of unassigned conversations in Mailbox menu
        \Eventy::addAction('menu.mailbox_single.before_name', function($mailbox_item) {
			if ('before' == \Option::get('unassignedcount.unassigned_count_position', \Config::get('unassignedcount.unassigned_count_position')))
	            echo $this->getNumberOfUnassignedConversationsText($mailbox_item);
        });
        
        // Show number of unassigned conversations in Mailbox menu
        \Eventy::addAction('menu.mailbox_single.after_name', function($mailbox_item) {
			if ('after' == \Option::get('unassignedcount.unassigned_count_position', \Config::get('unassignedcount.unassigned_count_position')))
	            echo $this->getNumberOfUnassignedConversationsText($mailbox_item);
        });
        
        // Show number of unassigned conversations in Mailbox menu
        \Eventy::addAction('menu.mailbox.before_name', function($mailbox_item) {
			if ('before' == \Option::get('unassignedcount.unassigned_count_position', \Config::get('unassignedcount.unassigned_count_position')))
	            echo $this->getNumberOfUnassignedConversationsText($mailbox_item);
        });
        
		// Show number of unassigned conversations in Mailbox menu
		\Eventy::addAction('menu.mailbox.after_name', function($mailbox_item) {
			if ('after' == \Option::get('unassignedcount.unassigned_count_position', \Config::get('unassignedcount.unassigned_count_position')))
				echo $this->getNumberOfUnassignedConversationsText($mailbox_item);
		});
	}

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTranslations();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('unassignedcount.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'unassignedcount'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/unassignedcount');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/unassignedcount';
        }, \Config::get('view.paths')), [$sourcePath]), 'unassignedcount');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadJsonTranslationsFrom(__DIR__ .'/../Resources/lang');
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
