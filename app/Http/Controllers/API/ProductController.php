<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Helpers\ResponseFormatter as Response;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {

        // handle input request user 
        $id = $request->input('id');
        $limit = $request->input('limit');
        $description = $request->input('description');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        $tags = $request->input('tags');
        $categories = $request->input('categories');
        $name = $request->input('name');

        // jika user request id
        if ($id) {
            // cari relasi berdasarkan id
            $product = Product::with(['productGalleries', 'categories'])->find($id);

            // kalo ketemu :
            if ($product) {
                return Response::success($product, 'OK');
            } else { // Kalo gak :
                return Response::error(null, 'FAILED NOT FOUND', 404);
            }
        }

        $product = Product::with(['productGalleries', 'categories']);

        // FIND BY name
        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        // FIND BY category
        if ($categories) {
            $product->where('categories_id', $categories);
        }

        // FIND BY tags
        if ($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }

        // FIND BY desc
        if ($description) {
            $product->where('description', 'like', '%', $description . '%');
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        // RETURN ALL DATA AND PAGINATE LIMIT
        return Response::success($product->paginate($limit), 'OK');
    }
}
