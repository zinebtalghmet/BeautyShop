<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        if ($request->filled('status')) {
            $request->status === 'active'
                ? $query->active()
                : $query->where('is_active', false);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['original_price']) && $data['discount'] ?? 0 > 0) {
            $data['original_price'] = $data['price'];
        }
        if (!empty($data['original_price']) && $data['original_price'] > $data['price']) {
            $data['discount'] = round((1 - $data['price'] / $data['original_price']) * 100);
        }

        $product = Product::create($data);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', "Product '{$product->name}' created successfully.");
    }

    public function edit(Product $product): View
    {
        $categories = Category::active()->ordered()->get();
        $product->load('images');

        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['original_price']) && ($data['discount'] ?? 0) > 0) {
            $data['original_price'] = $data['price'];
        }
        if (!empty($data['original_price']) && $data['original_price'] > $data['price']) {
            $data['discount'] = round((1 - $data['price'] / $data['original_price']) * 100);
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', "Product '{$product->name}' updated successfully.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$name}' deleted successfully.");
    }
}
