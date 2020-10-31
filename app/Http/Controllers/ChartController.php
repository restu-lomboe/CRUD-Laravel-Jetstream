<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderProduct;

class ChartController extends Controller
{
    public function index()
    {
        return view ('chart.index');
    }
}
