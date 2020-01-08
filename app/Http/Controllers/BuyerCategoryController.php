<?php

namespace App\Http\Controllers;

use App\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $seller = $buyer->transactions()->with('product.categories')
        ->get()
        ->pluck('product.categories')
        ->collapse()
        ->unique('id')
        ->values();

        return response()->json($seller);
    }

}
