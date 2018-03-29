<?php

namespace App\Listeners\Backend\Auth\User;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('Chef Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Chef Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Chef Deleted');
    }

    /**
     * @param $event
     */
    public function onConfirmed($event)
    {
        \Log::info('Chef Confirmed');
    }

    /**
     * @param $event
     */
    public function onUnconfirmed($event)
    {
        \Log::info('Chef Unconfirmed');
    }

    /**
     * @param $event
     */
    public function onPasswordChanged($event)
    {
        \Log::info('Chef Password Changed');
    }

    /**
     * @param $event
     */
    public function onDeactivated($event)
    {
        \Log::info('Chef Deactivated');
    }

    /**
     * @param $event
     */
    public function onReactivated($event)
    {
        \Log::info('Chef Reactivated');
    }

    /**
     * @param $event
     */
    public function onSocialDeleted($event)
    {
        \Log::info('Chef Social Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('Chef Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('Chef Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Auth\User\UserCreated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUpdated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserConfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onConfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUnconfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUnconfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPasswordChanged::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPasswordChanged'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserReactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onReactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserSocialDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onSocialDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPermanentlyDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserRestored::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onRestored'
        );
    }
}
