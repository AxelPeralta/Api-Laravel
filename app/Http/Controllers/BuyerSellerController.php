<?php

namespace App\Http\Controllers;

use App\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $seller = $buyer->transactions()->with('product.seller')
        ->get()
        ->pluck('product.seller')
        ->unique('id')
        ->values();

        return response()->json($seller);
    }
}
