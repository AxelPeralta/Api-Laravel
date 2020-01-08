<?php

namespace App\Http\Controllers;

use App\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $buyer = $seller->products()
        ->whereHas('transactions')
        ->with('transactions.buyer')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->pluck('buyer')
        ->unique()
        ->values();

        return response()->json($buyer);
    }

}
