<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\RolInterface;
use App\Repositories\Eloquent\RolRepository;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\AuthInterface;
use App\Repositories\Eloquent\AuthRepository;

class ServiceProviderRepository extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RolInterface::class, RolRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
