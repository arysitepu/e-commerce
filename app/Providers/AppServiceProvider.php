<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Order;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(Router $router): void
    {
        $router->aliasMiddleware('role', RoleMiddleware::class);
        View::composer('*', function ($view) {

            // COUNT CART
             $user = Auth::user();
             $cartCount = 0;
             if ($user) {
            $order = Order::where('user_id', $user->id)
                            ->where('status', 'pending')
                            ->first();

                if ($order) {
                    $cartCount = $order->orderItems()->sum('quantity');
                }
            }
            // BATAS
            $view->with('cartCount', $cartCount);
            $view->with('user', Auth::user());
            $view->with('rekenings', Rekening::with('bank')->orderBy('created_at', 'desc')->get());
        });
    }
}
