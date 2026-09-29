<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Content;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PhaseZeroSeeder extends Seeder
{
    public function run(): void
    {
        $pageData = [
            ['name' => 'Page 1 · Problem / Solution', 'content_style' => 'image_post', 'description' => 'Image post: problem to solution.'],
            ['name' => 'Page 2 · Deal / Value', 'content_style' => 'image_post', 'description' => 'Image post: price, value, and features.'],
            ['name' => 'Page 3 · Story Video', 'content_style' => 'ai_video', 'description' => 'AI video concept: story and problem to solution.'],
            ['name' => 'Page 4 · Visual Demo', 'content_style' => 'ai_video', 'description' => 'AI video concept: before and after.'],
            ['name' => 'Page 5 · Real Product', 'content_style' => 'real_review', 'description' => 'Real use and review after receiving the product.'],
        ];
        $pages = [];
        foreach ($pageData as $row) {
            $pages[] = Page::updateOrCreate(['name' => $row['name']], $row + ['platform' => 'mock', 'active' => true]);
        }

        $names = [
            'Foldable desk lamp', 'Compact storage box', 'Kitchen timer', 'Reusable water bottle',
            'Cable organizer', 'Travel pouch', 'Desk mat', 'Silicone spatula',
            'Phone stand', 'Laundry basket', 'Notebook set', 'Mini plant pot',
            'Food container set', 'Shoe rack', 'Wireless mouse pad', 'Microfiber cloth set',
            'Bathroom shelf', 'Lunch bag', 'Book light', 'Drawer divider',
            'Coffee scoop', 'Pet feeding mat', 'Laptop sleeve', 'Packing cube set',
        ];
        $categories = ['Home', 'Kitchen', 'Office', 'Travel'];
        $statuses = ProductStatus::values();
        $products = [];
        foreach ($names as $i => $name) {
            $number = $i + 1;
            $extra = $number % 4 !== 0;
            $score = [92, 77, 58, 84, 69, 43][$i % 6];
            $product = Product::updateOrCreate(['external_product_id' => sprintf('MOCK-%03d', $number)], [
                'product_name' => $name,
                'category' => $categories[$i % count($categories)],
                'shop_name' => 'Demo Shop '.(($i % 4) + 1),
                'product_url' => "https://example.com/products/{$number}",
                'affiliate_url' => $number % 5 === 0 ? null : "https://example.com/affiliate/product-{$number}",
                'price' => 149 + $number * 21,
                'sale_price' => 129 + $number * 18,
                'rating' => round(3.8 + ($i % 10) * 0.1, 2),
                'review_count' => 30 + $number * 13,
                'sold_count' => 120 + $number * 75,
                'base_commission' => 2.5 + ($i % 3),
                'extra_commission' => $extra ? 3.0 + ($i % 5) : null,
                'has_extra_comm' => $extra,
                'product_status' => $statuses[$i % count($statuses)],
                'opportunity_score' => $score,
                'score_status' => $score >= 80 ? 'hot' : ($score >= 65 ? 'watch' : 'low'),
                'notes' => 'Fictional Phase 0 product. No live marketplace data.',
                'last_checked_at' => now()->subHours($number),
                'extra_comm_checked_at' => now()->subHours($number + 1),
                'affiliate_link_checked_at' => now()->subHours($number + 2),
                'images_checked_at' => now()->subHours($number + 3),
            ]);
            $products[] = $product;
            $imageCount = $number % 7 === 0 ? 0 : ($number % 3 === 0 ? 1 : 3);
            for ($j = 0; $j < $imageCount; $j++) {
                $asset = 'mock-products/placeholder-'.(($i + $j) % 4 + 1).'.svg';
                $product->images()->firstOrCreate(['sort_order' => $j], [
                    'image_url' => asset($asset),
                    'local_path' => $asset,
                    'image_type' => $j === 0 ? 'main' : 'gallery',
                    'download_status' => 'mock',
                ]);
            }
            if ($number <= 8) {
                foreach ([7, 3, 0] as $daysAgo) {
                    $date = now()->subDays($daysAgo)->toDateString();
                    $snapshot = $product->snapshots()->whereDate('snapshot_date', $date)->first()
                        ?? $product->snapshots()->make(['snapshot_date' => $date]);
                    $snapshot->fill([
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'rating' => $product->rating,
                        'review_count' => $product->review_count - $daysAgo * 2,
                        'sold_count' => $product->sold_count - $daysAgo * 8,
                        'base_commission' => $product->base_commission,
                        'extra_commission' => $product->extra_commission,
                        'has_extra_comm' => $extra,
                        'created_at' => now(),
                    ])->save();
                }
            }
        }

        foreach (range(0, 7) as $i) {
            $product = $products[$i];
            if (! $product->has_extra_comm) {
                continue;
            }
            $page = $pages[$i % 4];
            Content::firstOrCreate(['product_id' => $product->id, 'page_id' => $page->id, 'content_type' => $page->content_style], [
                'content_angle' => $page->description,
                'hook' => 'Could this product simplify a common daily task?',
                'caption' => 'Demo content concept based on product information only. Verify product details before posting.',
                'script' => $page->content_style === 'ai_video' ? 'Show a common problem, introduce the product, then show the proposed benefit.' : null,
                'experience_basis' => 'non_personal',
                'status' => 'draft',
            ]);
        }
        $received = collect($products)->first(fn ($product) => $product->has_extra_comm && $product->product_status->permitsRealExperience());
        if ($received) {
            Content::firstOrCreate(['product_id' => $received->id, 'page_id' => $pages[4]->id, 'content_type' => 'real_review'], [
                'content_angle' => 'Real product demonstration',
                'hook' => 'Real review draft — record observations after testing the item.',
                'experience_basis' => 'real_use',
                'status' => 'draft',
            ]);
        }
    }
}
