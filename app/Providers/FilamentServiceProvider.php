<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use App\Filament\Widgets\AttendanceFilterWidget;


class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap services.
     */
    // public function boot(): void
    // {
    //     Filament::serving(function () {
    //         // Register your custom JavaScript file globally
    //         Filament::registerAssets([
    //             asset('js/live-video-scanner.js'),
    //         ], 'script');
    //     });
    // }
    public function widgets(): array
{
    return [
        AttendanceFilterWidget::class,
        // Other widgets
    ];
}
}
