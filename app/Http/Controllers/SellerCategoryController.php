<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
        ->with('categories')
        ->get()
        ->pluck('categories')
        ->collapse()
        ->unique('id')
        ->values();

        return response()->json($categories);
    }

}
