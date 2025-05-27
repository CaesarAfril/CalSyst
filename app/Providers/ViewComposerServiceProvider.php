<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\SidebarComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bind the view composer to a specific view
        View::composer('templates.templates', SidebarComposer::class);

        // Or if your sidebar is a partial:
        // View::composer('partials.sidebar', SidebarComposer::class);
    }
}
