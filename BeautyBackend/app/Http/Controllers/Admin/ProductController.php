<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        if (isset($data['features']) && is_string($data['features'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        }

        if (empty($data['original_price']) && ($data['discount'] ?? 0) > 0) {
            $data['original_price'] = $data['price'];
        }
        if (!empty($data['original_price']) && $data['original_price'] > $data['price']) {
            $data['discount'] = round((1 - $data['price'] / $data['original_price']) * 100);
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image' => $path,
                        'sort_order' => $i,
                    ]);
                }
            }
        }

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

        if (isset($data['features']) && is_string($data['features'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        }

        if (empty($data['original_price']) && ($data['discount'] ?? 0) > 0) {
            $data['original_price'] = $data['price'];
        }
        if (!empty($data['original_price']) && $data['original_price'] > $data['price']) {
            $data['discount'] = round((1 - $data['price'] / $data['original_price']) * 100);
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            $lastSort = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $lastSort + 1 + $i,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', "Product '{$product->name}' updated successfully.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$name}' deleted successfully.");
    }

    public function destroyImage(Product $product, ProductImage $image): RedirectResponse
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Image deleted successfully.');
    }
}
