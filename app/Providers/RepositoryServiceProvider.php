<?php

namespace App\Providers;

use App\Repository\Auth\DbAuthRepository;
use App\Repository\Auth\InterfaceAuthRepository;
use App\Repository\Dashboard\DbDashboardRepository;
use App\Repository\Dashboard\InterfaceDashboardRepository;
use App\Repository\Profile\DbProfileRepository;
use App\Repository\Profile\InterfaceProfileRpository;
use App\Repository\Projects\DbProjectRepository;
use App\Repository\Projects\InterfaceProjectRepository;
use App\Repository\Users\DbUserRepository;
use App\Repository\Users\InterfaceUserRepository;
use App\Repository\Tasks\InterfaceTaskRepository;
use App\Tasks\Repository\tasks\DbTaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InterfaceTaskRepository::class,        DbTaskRepository::class);
        $this->app->bind(InterfaceUserRepository::class,        DbUserRepository::class);
        $this->app->bind(InterfaceProjectRepository::class,     DbProjectRepository::class);
        $this->app->bind(InterfaceProfileRpository::class,      DbProfileRepository::class);
        $this->app->bind(InterfaceDashboardRepository::class,   DbDashboardRepository::class);
        $this->app->bind(InterfaceAuthRepository::class,        DbAuthRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
