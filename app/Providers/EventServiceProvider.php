<?php

namespace App\Providers;

use App\Models\Cobranca;
use App\Models\User;
use App\Observers\CobrancaObserver;
use App\Observers\NewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        User::class => [NewUser::class],
        Cobranca::class => [CobrancaObserver::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(NewUser::class);
        Cobranca::observe(CobrancaObserver::class);
    }
}
