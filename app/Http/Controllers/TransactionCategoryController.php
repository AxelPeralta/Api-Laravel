<?php
namespace App\Http\Controllers;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {   
        $producto= $transaction->product->categories;

        return response()->json($producto);
    }


}
