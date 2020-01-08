<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\User;
use App\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

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
        User::created(function($user) {
          Mail::to($user)->send(new UserCreated($user));
        });

        Product::updated(function($product) {
            if($product->quantity == 0 && $product->estaDisponible()){
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;

                $product->save();
            }
        });
    }
}
