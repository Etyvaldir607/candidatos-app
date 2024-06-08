<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GlobalTrackingObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        if (Auth::check()) {
            $model->created_by = Auth::id();
            $model->saveQuietly();
        }
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        if (Auth::check()) {
            $model->updated_by = Auth::id();
            $model->saveQuietly();
        }
    }

}
