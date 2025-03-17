<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use App\Filament\Pages\QrScanner;
use Filament\Panel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // if (env('APP_ENV') !== 'local' && !request()->secure()) {
        //     $url = "https://" . request()->getHost() . request()->getRequestUri();
        //     return redirect()->to($url, 301); // Use 301 for permanent redirection
        // }
        // if (config('app.env') !== 'local') {
        //     URL::forceScheme('https');
        // }
    }
}
