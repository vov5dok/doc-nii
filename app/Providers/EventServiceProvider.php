<?php

namespace App\Providers;

use App\Events\Contracts\StatementHistoryEvent;
use App\Events\UserActivated;
use App\Listeners\UpdateStatementHistory;
use App\Listeners\UserActivatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserActivated::class => [
            UserActivatedListener::class,
        ],
        StatementHistoryEvent::class => [
            UpdateStatementHistory::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
//        TODO : нужно для работы SEO
//        Event::listen('postHasViewed', function ($post) {
//            $post->increment('counter');
//        });
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
