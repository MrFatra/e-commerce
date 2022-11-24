<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Helpers\ResponseFormatter as Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            // cari relasi berdasarkan id
            $product = Category::with(['products'])->find($id);

            // kalo ketemu :
            if ($product) {
                return Response::success($product, 'OK');
            } else { // Kalo gak :
                return Response::error(null, 'FAILED NOT FOUND', 404);
            }
        }

        $categories = Category::query();

        if ($name) {
            $categories->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $categories->with(['products']);
        }

        return Response::success($categories->paginate($limit), 'OK');
    }
}
