<?php

namespace App\Http\Controllers\Api\V1;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('category')
        ->orderBy('id', 'desc')
        ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];

        $request->validate([
            'name' => 'required|max:200',
            'desc' => 'nullable',
            'category_id' => 'required|integer',
            'price_purchase' => 'required|numeric',
            'price_sale' => 'required|numeric',
        ]);

        $data = [
            'name' => $request->name,
            'desc' => $request->desc,
            'category_id' => $request->category_id,
            'price_purchase' => $request->price_purchase,
            'price_sale' => $request->price_sale,
        ];

        if ($request->has('stock')) {
            $request->validate([
                'stock' => 'nullable|numeric|min:1'
            ]);
            $data['stock'] = $request->stock;
        }

        return Product::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrfail($id);

        if ($request->has('name')) {
            $request->validate([
                'name' => 'required|max:100'
            ]);
            $category->name = $request->name;
        }

        $category->save();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);

        return response()->json([
            'message' => 'success delete category data'
        ], 200);
    }
}
