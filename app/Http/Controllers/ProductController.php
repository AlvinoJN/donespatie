<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request )
    {
        // Panggil scope di model untuk produk terbar

        if (request()->ajax()) {
            $products = Product::query();
            return DataTables::of($products)
                ->make();
        }
        return view('products.index');
    }

    public function show(Product $product)
    {
        // Detail produk
        return view('products.show', compact('product'));
    }

    public function create()
    {
        // Tampilkan form untuk membuat produk
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $productData = $request->all();
        $productData['id'] = (string) \Illuminate\Support\Str::uuid();

        Product::create($productData);

        return redirect()->route('products.index')
            ->withSuccess('New product is added successfully.');
    }

    public function edit(Product $product)
    {
        // Tampilkan form untuk mengedit produk
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        // Validasi dan update produk
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $product->updateProduct($request->only('name', 'description'));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        // Hapus produk
        $product = Product::find($id);

        $product->delete();
    }
}
