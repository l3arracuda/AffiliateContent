<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class AffiliateCopyController extends Controller
{
    public function __invoke(Product $product): JsonResponse
    {
        if (blank($product->affiliate_url)) {
            return response()->json(['message' => 'No affiliate link is available.'], 422);
        }
        $product->activityLogs()->create(['event' => 'product.affiliate_link_copied']);

        return response()->json(['ok' => true]);
    }
}
