<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notifications\Channels\LineChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;


class NotificationChannelServiceProvider extends ServiceProvider
{
    public $singletons = [
        'line' => LineChannel::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /** ref : https://laracasts.com/discuss/channels/laravel/register-custom-notification-channel-from-array
         * The resolved method is available on all facades and runs when the facade... gets resolved. 
         * Inside its callback, you can extend the related service's drivers. 
         * The first parameter is the name of the custom driver and the callback should return a class instance
         */
        //ChannelManagerを拡張する
        Notification::resolved(function (ChannelManager $service) {
            //extend service's driverを追加できる
            $service->extend('line', function ($app) {
                return $app->make('line');
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
