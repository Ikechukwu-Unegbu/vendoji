<?php

namespace App\Providers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        PaginationPaginator::useBootstrapFive();
        $this->loadMigrationsFrom('database/migrations/banks');
        $this->loadMigrationsFrom('database/migrations/core');
        $this->loadMigrationsFrom('database/migrations/extras');
        $this->loadMigrationsFrom('database/migrations/transactions');
        Schema::defaultStringLength(191); //Update defaultStringLength
    }
}
