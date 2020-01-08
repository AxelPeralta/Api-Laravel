<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategorySellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $sellers = $category->Products()
        ->with('seller')
        ->get()
        ->pluck('seller')
        ->unique()
        ->values();

        return response()->json($sellers);
    }
}
