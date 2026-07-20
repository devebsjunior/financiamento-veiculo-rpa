<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Contracts\CryptoServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\CryptoService;
use App\Services\TokenService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            CryptoServiceInterface::class,
            CryptoService::class
        );

        $this->app->bind(
            TokenServiceInterface::class,
            TokenService::class
        );
    }

    public function boot(): void
    {
        //
    }
}
