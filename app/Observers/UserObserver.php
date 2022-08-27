<?php

namespace App\Observers;

use App\Models\User;

use App\Notifications\UserObserveNotification;

use Illuminate\Support\Facades\Mail; //追記
use App\Mail\UserRegisteredMail; //追記

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
        //ユーザーに対して、登録が完了した旨と管理者による作業を待ってほしい旨通知する
        $user->notify(new UserObserveNotification());
        
        //ユーザーが登録されたことを管理者に伝える
        Mail::send(new UserRegisteredMail($user->name));

    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
        // $user->setUserTypeStatus();
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
        // $user->setUserTypeStatus();
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
