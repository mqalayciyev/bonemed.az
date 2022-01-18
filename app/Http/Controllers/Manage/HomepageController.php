<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    public function index()
    {
        $best_seller = DB::select("
            SELECT p.product_name, SUM(cp.piece) piece
            FROM `order` o 
            INNER JOIN cart c ON c.id = o.cart_id
            INNER JOIN cart_product cp ON c.id = cp.cart_id
            INNER JOIN product p ON p.id = cp.product_id
            GROUP BY p.product_name
            ORDER BY SUM(cp.piece) DESC
        ");

        $monthly = DB::select("
            SELECT
              DATE_FORMAT(o.created_at, '%Y-%m') month, sum(cp.piece) piece
            FROM `order` o
            INNER JOIN cart c on c.id = o.cart_id
            INNER JOIN cart_product cp on c.id=cp.cart_id
            GROUP BY DATE_FORMAT(o.created_at, '%Y-%m')
            ORDER BY DATE_FORMAT(o.created_at, '%Y-%m')
        ");

        return view('manage.pages.homepage', compact('best_seller', 'monthly'));
    }
}
