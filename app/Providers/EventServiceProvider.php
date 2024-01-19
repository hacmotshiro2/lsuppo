<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// No. h.hashimoto 2022/08/25 ------>
use App\Models\User;
use App\Observers\UserObserver;
// <------  No. h.hashimoto 2022/08/25 

// No.Ph.2.4 h.hashimoto 2024/01/19 ------>
use App\Listeners\LogNotification;
use Illuminate\Notifications\Events\NotificationSent;
// <------  No.Ph.2.4 h.hashimoto 2024/01/19 


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        //event関数にRegisteredクラスがはいったらSendEmailVerificationNotificationクラスに送られる
        //メール認証は初期ではOFFになっている
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // No.Ph.2.4 h.hashimoto 2024/01/19 ------>
        NotificationSent::class => [
            LogNotification::class,
        ],
        // <------  No.Ph.2.4 h.hashimoto 2024/01/19 
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        // No. h.hashimoto 2022/08/25 ------>
        User::observe(UserObserver::class);
        // <------  No. h.hashimoto 2022/08/25 

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
