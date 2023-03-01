<?php

namespace App\Providers;

use Exception;
use App\Models\GeneralSetting;
use App\Models\SettingSmtp;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        setlocale(LC_TIME, 'pt-br');
        Paginator::useBootstrap();

        try {
            $setting = SettingSmtp::first();

            if($setting){
                Config::set('mail.mailers.smtp.host', $setting->host);
                Config::set('mail.mailers.smtp.port', $setting->port);
                Config::set('mail.mailers.smtp.username', $setting->user);
                Config::set('mail.mailers.smtp.password', $setting->password);
                Config::set('mail.mailers.smtp.encryption', 'ssl');
            }
        } catch (Exception $e) {}

        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
