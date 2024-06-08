<?php

namespace App\Observers;


use App\Observers\GlobalTrackingObserver;

trait GlobalTrackingTrait
{
    public static function bootGlobalTrackingTrait()
    {
        static::observe(GlobalTrackingObserver::class);
    }
}