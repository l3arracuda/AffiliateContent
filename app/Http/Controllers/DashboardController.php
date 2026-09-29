<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'stats' => [
                'Products found' => Product::count(),
                'Extra Comm' => Product::where('has_extra_comm', true)->count(),
                'Ready for content' => Product::mainOpportunity()->whereNotNull('affiliate_url')->has('images')->count(),
                'Testing' => Product::where('product_status', ProductStatus::Testing)->count(),
                'Winners' => Product::where('product_status', ProductStatus::Winner)->count(),
                'Ordered' => Product::where('product_status', ProductStatus::Ordered)->count(),
                'Real review ready' => Product::where('product_status', ProductStatus::Received)->count(),
            ],
            'products' => Product::mainOpportunity()->with('images')->withCount('images')->orderByDesc('opportunity_score')->limit(6)->get(),
        ]);
    }
}
