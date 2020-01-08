<?php
use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //desbloquear el chequeo de las llaves foraneas
        // DB::statement('SET FOREIGN_KEY_CHECKS= 0');

        // User::truncate();
        // Category::truncate();
        // Product::truncate();
        // Transaction::truncate();
        // DB::table('category_product')-truncate();

        $cantidadUsuarios=800;
        $cantidadCategorias=20;
        $cantidadProductos=20;
        $cantidadTransacciones=800;

        factory(User::class,$cantidadUsuarios)->create();
        factory(Category::class,$cantidadCategorias)->create();

        factory(Product::class, $cantidadProductos)->create()->each(
            function ($producto){
                //pluck coleccion de laravel que nos retorna solo 1 elemento
                $categorias= Category::all()->random(mt_rand(1,5))->pluck('id');
                //attach
                $producto->categories()->attach($categorias);
            }
        );

        factory(Transaction::class,$cantidadUsuarios)->create();
    }
}
