<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
        // Pagination Collections
        Collection::macro('paginate', function($perPage, $path=null, $total = null, $page = null, $pageName = 'page') {
            $page = $page?: LengthAwarePaginator::resolveCurrentPage($pageName);
            $path = $path? $path: LengthAwarePaginator::resolveCurrentPath();

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => $path,
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
