<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketWatchController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'extra_comm' => ['nullable', 'in:0,1'],
            'affiliate' => ['nullable', 'in:0,1'],
            'images' => ['nullable', 'in:0,1'],
            'category' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:'.implode(',', ProductStatus::values())],
            'min_score' => ['nullable', 'integer', 'between:0,100'],
        ]);
        $marketWatch = $request->routeIs('market-watch.index');
        $extraOnly = array_key_exists('extra_comm', $filters) ? $filters['extra_comm'] === '1' : $marketWatch;
        $query = Product::query()->with('images')->withCount('images');
        if ($extraOnly) {
            $query->mainOpportunity();
        }
        if (($filters['affiliate'] ?? '0') === '1') {
            $query->whereNotNull('affiliate_url')->where('affiliate_url', '!=', '');
        }
        if (($filters['images'] ?? '0') === '1') {
            $query->has('images');
        }
        if (filled($filters['category'] ?? null)) {
            $query->where('category', $filters['category']);
        }
        if (filled($filters['status'] ?? null)) {
            $query->where('product_status', $filters['status']);
        }
        if (isset($filters['min_score'])) {
            $query->where('opportunity_score', '>=', $filters['min_score']);
        }

        return view('products.index', [
            'title' => $marketWatch ? 'Market Watch' : 'Products',
            'products' => $query->orderByDesc('opportunity_score')->orderBy('id')->paginate(12)->withQueryString(),
            'categories' => Product::whereNotNull('category')->distinct()->orderBy('category')->pluck('category'),
            'filters' => $filters,
            'extraOnly' => $extraOnly,
        ]);
    }
}
