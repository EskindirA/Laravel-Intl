<?php namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Country\CountryRepository;
use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\Language\LanguageRepository;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Illuminate\Support\ServiceProvider;

class IntlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCountryRepository();
        $this->registerCurrencyRepository();
        $this->registerLanguageRepository();
        $this->registerNumberRepository();

        $this->registerDateHandler();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the country repository.
     *
     * @return void
     */
    protected function registerCountryRepository()
    {
        $this->app->singleton('CommerceGuys\Intl\Country\CountryRepository', function ($app) {
            $repository = new CountryRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias('Propaganistas\LaravelIntl\Country', 'intl.country');
    }

    /**
     * Register the currency repository.
     *
     * @return void
     */
    protected function registerCurrencyRepository()
    {
        $this->app->singleton('CommerceGuys\Intl\Currency\CurrencyRepository', function ($app) {
            $repository = new CurrencyRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias('Propaganistas\LaravelIntl\Currency', 'intl.currency');
    }

    /**
     * Register the language repository.
     *
     * @return void
     */
    protected function registerLanguageRepository()
    {
        $this->app->singleton('CommerceGuys\Intl\Language\LanguageRepository', function ($app) {
            $repository = new LanguageRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias('Propaganistas\LaravelIntl\Language', 'intl.language');
    }

    /**
     * Register the number repository.
     *
     * @return void
     */
    protected function registerNumberRepository()
    {
        $this->app->singleton('CommerceGuys\Intl\NumberFormat\NumberFormatRepository', function ($app) {
            $repository = new NumberFormatRepository;
            $repository->setDefaultLocale($app['config']['app.locale']);
            $repository->setFallbackLocale($app['config']['app.fallback_locale']);

            return $repository;
        });

        $this->app->alias('Propaganistas\LaravelIntl\Number', 'intl.number');
    }

    /**
     * Register the date handler.
     *
     * @return void
     */
    protected function registerDateHandler()
    {
        $this->app->register('Jenssegers\Date\DateServiceProvider');

        $this->app->booted(function ($app) {
            \Jenssegers\Date\Date::setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->singleton('Carbon\Carbon', function () {
            return new Date;
        });

        $this->app->alias('Carbon\Carbon', 'intl.date');
    }
}
