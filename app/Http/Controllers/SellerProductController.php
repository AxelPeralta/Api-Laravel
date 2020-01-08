<?php

namespace App\Http\Controllers;

use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return response()->json($products);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        $validator = Validator::make ($request -> all(), [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
         ]);
        if ($validator->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'Validation incorrect' , "code" => 409], 409);
         }
         $data = $request ->all();
         $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
         $data['image'] = $request->image->store('');
         // $campos['verification_token'] =User::GVT;
         $data['seller_id'] = $seller->id;
 
         $product = Product::create($data);
 
         return response()->json($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller , Product $product)
    {
        $validator = Validator::make ($request -> all(), [
            'quantity' => 'integer|min:1',
         ]);
        if ($validator->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'validacion incorrecta en la cantidad' , "code" => 409], 409);
         }

         $validator2 = Validator::make ($request -> all(), [
            'status' => 'in:'.Product::PRODUCTO_DISPONIBLE.','.Product::PRODUCTO_NO_DISPONIBLE,
         ]);
        if ($validator2->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'validacion incorrecta en el status' , "code" => 409], 409);
         }

         $validator3 = Validator::make ($request -> all(), [
            'image' => 'image',
         ]);
        if ($validator3->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'validacion incorrecta en la imagen' , "code" => 409], 409);
         }


         if($seller->id != $product->seller_id){
            return response()->json(["Error" => 'El vendedor seleccionado no es le vendedor original del producto']);
         }

        $product->fill($request->only([
            'image',
            'status',
            'quantity',
            'name',
            'description'
        ]));
        
        //borra la imagen existente y crea una nueva sin importar que la img tenga el mismo nombre
        //es necesario usar el atributo _method con el valor put en la peticion
        if($request->hasFile('image')){
            Storage::delete($product->image);

            $product->image = $request->image->storage('');
        }

        if($product->isClean()){
            return response()->json('debe de haber un campo minimo a actualizar');
        }

        $product->save();

        return response()->json($product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {   
        //primero verifica si el vendedor coincide con el id del vendedor en el producto de lo contrario avienta un error
        $this->verificarVendedor($seller,$product);
        //elimina la imagen con el facade Storage
        Storage::delete($product->image);
        $product->delete();
        return response()->json($product);

    }
    protected function verificarVendedor(Seller $seller, Product $product){
        if($seller->id != $product->seller_id){
            return response()->json(["Error" => 'El vendedor seleccionado no es le vendedor original del producto a borrar']);
         }
    }
}
