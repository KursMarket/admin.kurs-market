<?php

namespace App\Providers;

use App\Services\AuthServiceImpl;
use App\Services\CatalogTypeServiceImpl;
use App\Services\CategoryServiceImpl;
use App\Services\CourseServiceImpl;
use App\Services\Interfaces\AuthService;
use App\Services\Interfaces\CatalogTypeService;
use App\Services\Interfaces\CategoryService;
use App\Services\Interfaces\CourseService;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Services\ReviewService;
use App\Services\Interfaces\SaleService;
use App\Services\Interfaces\SettingService;
use App\Services\Interfaces\StudyDurationService;
use App\Services\Interfaces\TagService;
use App\Services\SaleServiceImpl;
use App\Services\SettingServiceImpl;
use App\Services\StudyDurationServiceImpl;
use App\Services\TagServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            AuthService::class,
            AuthServiceImpl::class
        );

        $this->app->bind(
            CatalogTypeService::class,
            CatalogTypeServiceImpl::class
        );

        $this->app->bind(
            CategoryService::class,
            CategoryServiceImpl::class
        );

        $this->app->bind(
            CourseService::class,
            CourseServiceImpl::class
        );

        $this->app->bind(
            TagService::class,
            TagServiceImpl::class
        );

        $this->app->bind(
            StudyDurationService::class,
            StudyDurationServiceImpl::class
        );

        $this->app->bind(
            ReviewServiceInterface::class,
            ReviewService::class,
        );
        
        $this
            ->app
            ->bind(
                SettingService::class,
                SettingServiceImpl::class
            )
        ;

        $this
            ->app
            ->bind(
                SaleService::class,
                SaleServiceImpl::class
            )
        ;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
