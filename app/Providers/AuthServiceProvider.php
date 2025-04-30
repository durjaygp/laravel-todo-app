<?php

namespace App\Providers;

use App\Models\Card;
use App\Policies\CardPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    protected $policies = [
        Card::class => CardPolicy::class,
    ];

    public function boot(): void
    {
        //$this->registerPolicies();
    }
}
