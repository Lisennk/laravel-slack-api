<?php

namespace Vluzrmos\SlackApi;

use Illuminate\Support\ServiceProvider;

use Vluzrmos\SlackApi\Methods\Channel;
use Vluzrmos\SlackApi\Methods\Group;
use Vluzrmos\SlackApi\Methods\Chat;
use Vluzrmos\SlackApi\Methods\InstantMessage;
use Vluzrmos\SlackApi\Methods\Search;
use Vluzrmos\SlackApi\Methods\File;

class SlackApiServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        /* Lumen autoload services configs */
        if (str_contains($this->app->version(), 'Lumen')) {
            $this->app->configure('services');
        }

        $this->app->singleton('slackapi', function () {
            $api = new SlackApi(null, config('services.slack.token'));

            return $api;
        });

        $this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackApi', function () {
            return $this->app['slackapi'];
        });

		$this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackChannel', function () {
			return new Channel($this->app['slackapi']);
		});

		$this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackChat', function () {
			return new Chat($this->app['slackapi']);
		});

		$this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackGroup', function () {
			return new Group($this->app['slackapi']);
		});

		$this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackInstantMessage', function () {
			return new InstantMessage($this->app['slackapi']);
		});

		$this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackSearch', function () {
			return new Search($this->app['slackapi']);
		});

		$this->app->singleton('Vluzrmos\SlackApi\Contracts\SlackFile', function () {
			return new File($this->app['slackapi']);
		});
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['slackapi', 'Vluzrmos\SlackApi\Contracts\SlackApi'];
    }
}
