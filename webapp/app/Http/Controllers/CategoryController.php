<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    const PAGE_SIZE = 6;

    public function index(Request $request, $category, $page)
    {
        $gender = $request->input('gender');
        $total_count = $this->countProducts($gender);
        $max_page = ceil($total_count / self::PAGE_SIZE);
        $clamped_page = max(1, min($max_page, ((int)$page)));
        if ($page == $clamped_page)
        {
            return view('category')->with([
                'products' => $this->getProducts($category, $page, $gender),
                'max_page' => $max_page,
                'min_page' => 0,
                'current_page' => $page,
                'category' => $category,
                'gender' => $gender
            ]);
        }
        else
        {
            return redirect()->action('CategoryController@index', [
                'category' => $category,
                'page' => $clamped_page,
                'gender' => $gender
            ]);
        }
    }

    private function getProducts(string $category, int $page, string $gender = null) {
        $offset = ($page-1) * self::PAGE_SIZE;
        $sql = DB::table('products')->where('category', $category);
        if ($gender) $sql->where('gender', $gender);
        return $sql->skip($offset)->limit(self::PAGE_SIZE)->get();
    }

    private function countProducts(string $gender = null) {
        $sql = DB::table('products');
        if ($gender) $sql->where('gender', $gender);
        return $sql->count();
    }
}
