<?php

namespace App\Listeners;

use App\Events\UserActivated;
use App\Mail\WelcomeMail;
use App\Models\MoonshineUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserActivatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserActivated $event
     * @return void
     */
    public function handle(UserActivated $event): void
    {
        MoonshineUser::when(null !== $event->id, function (Builder $query) use ($event){
            $query->whereIn('id', (array)$event->id);
        })->get()->each(function (MoonshineUser $moonshineUser){
            Mail::to($moonshineUser->email)->send(new WelcomeMail($moonshineUser));
        });
    }
}
