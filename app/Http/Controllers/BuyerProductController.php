<?php

namespace App\Http\Controllers;

use App\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // $products = $buyer->transactions->product;

        $products = $buyer->transactions()->with('product')
        ->get()
        ->pluck('product');
        // dd($products);
        return response()->json($products);
    }
}
