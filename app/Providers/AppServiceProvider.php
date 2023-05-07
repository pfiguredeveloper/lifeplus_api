<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB,Log;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mailer', function ($app) {
            $app->configure('services');
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
        });
        
    }
    
    public function boot(): void
    {
        \DB::listen(function ($query) {
            info("asdsadsad");
            $bindings = collect($query->bindings)->map(function ($param) {
                return is_numeric($param) ?  $param : "'$param'";
            });
          \Log::info(\Illuminate\Support\Str::replaceArray('?', $bindings->toArray(), $query->sql));
        });
    }
}
