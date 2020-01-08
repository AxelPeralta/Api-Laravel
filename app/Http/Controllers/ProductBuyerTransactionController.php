<?php

namespace App\Http\Controllers;

use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ProductBuyerTransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {

        $validator = Validator::make ($request -> all(), [
            'quantity' => 'required|integer|min:1',
         ]);
        if ($validator->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'Validacion incorrecta en la cantidad']);
         }

        if($buyer->id == $product->seller_id){
            return response()->json('el comprador debe de ser diferente al vendedor');
        }

        if(!$buyer ->esVerificado()){
            return response()->json('el comprador debe de ser un usuario verificado');
        }

        if(!$product->seller->esVerificado()){
            return response()->json('el vendedor debe de ser un usuario verificado');
        }

        if(!$product->estaDisponible()){
            return response()->json('el producto para esta transaccion debe de estar disponible');
        }

        if($product->quantity < $request->quantity){
            return response()->json('la cantidad deseada es mayor a la del stock del producto');
        }
        
        return DB::transaction(function () use ($request,$product,$buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' =>$product->id,
            ]);

            return response()->json($transaction);
        });

    }

}
