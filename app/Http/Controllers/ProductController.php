<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function create(): View
    {
        return view('products.form', ['product' => new Product, 'statuses' => ProductStatus::values()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $product = DB::transaction(function () use ($data) {
            $product = Product::create($data);
            $product->activityLogs()->create(['event' => 'product.created']);

            return $product;
        });

        return redirect()->route('products.show', $product)->with('success', 'Product created.');
    }

    public function show(Product $product): View
    {
        $product->load(['images', 'snapshots', 'contents.page', 'activityLogs'])->loadCount('images');

        return view('products.show', ['product' => $product, 'pages' => Page::all()]);
    }

    public function edit(Product $product): View
    {
        return view('products.form', ['product' => $product, 'statuses' => ProductStatus::values()]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product);
        DB::transaction(function () use ($product, $data) {
            $oldStatus = $product->product_status->value;
            $product->update($data);
            $product->activityLogs()->create(['event' => 'product.updated']);
            if ($oldStatus !== $product->product_status->value) {
                $product->activityLogs()->create(['event' => 'product.status_changed', 'details' => ['from' => $oldStatus, 'to' => $product->product_status->value]]);
            }
        });

        return redirect()->route('products.show', $product)->with('success', 'Product updated.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'external_product_id' => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product?->id)],
            'product_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'shop_name' => ['nullable', 'string', 'max:255'],
            'product_url' => ['nullable', 'url:http,https', 'max:2048'],
            'affiliate_url' => ['nullable', 'url:http,https', 'max:2048'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'review_count' => ['nullable', 'integer', 'min:0'],
            'sold_count' => ['nullable', 'integer', 'min:0'],
            'base_commission' => ['nullable', 'numeric', 'min:0'],
            'extra_commission' => ['nullable', 'numeric', 'min:0'],
            'product_status' => ['required', Rule::in(ProductStatus::values())],
            'opportunity_score' => ['nullable', 'integer', 'between:0,100'],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);
        $data['has_extra_comm'] = $request->boolean('has_extra_comm');
        $score = $data['opportunity_score'] ?? null;
        $data['score_status'] = $score === null ? null : ($score >= 80 ? 'hot' : ($score >= 65 ? 'watch' : 'low'));

        return $data;
    }
}
