<?php

namespace App\Http\Controllers;

use App\Seller;
use Illuminate\Http\Request;

class SellerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions=$seller->products()
        ->whereHas('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse();

        return response()->json($transactions);
    }
}
