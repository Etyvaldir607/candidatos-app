<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set the default response for API
        Response::macro('apiResponse', function ($data, string $message = null, int $code = 200) {
            return Response::json([
                'meta' => [
                    'success'   => true,
                    'errors'    => []
                ],
                'data' => $data,
            ], $code);
        });

        // Set the default response for API exceptions
        Response::macro('apiException', function (string|array $error, int $code = 400) {
            return Response::json([
                'meta' => [
                    'success'   => false,
                    'errors'    => $error
                ],
            ], ($code > 500 || $code < 200) ? 500 : $code);
        });
    }
}
