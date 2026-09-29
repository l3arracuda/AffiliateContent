<?php

namespace Tests\Feature;

use App\Enums\ProductStatus;
use App\Models\ActivityLog;
use App\Models\Content;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductSnapshot;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseZeroTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_seed_and_product_model_include_required_data(): void
    {
        $this->assertSame(24, Product::count());
        $this->assertSame(5, Page::count());
        $this->assertGreaterThan(0, Content::count());
        $this->assertSame(ProductStatus::Discovered, Product::first()->product_status);
        $this->assertNotNull(Product::first()->extra_comm_checked_at);
    }

    public function test_seeder_can_run_again_without_duplicate_snapshots(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(24, Product::count());
        $this->assertSame(24, ProductSnapshot::count());
        $this->assertSame(5, Page::count());
    }

    public function test_dashboard_reads_database_and_renders(): void
    {
        $this->get('/')->assertOk()->assertSee('Products found')->assertSee('24');
        $dashboard = $this->get('/');
        $this->assertSame(18, $dashboard->viewData('stats')['Extra Comm']);
        foreach ($dashboard->viewData('products') as $product) {
            $this->assertTrue($product->product_status->canEnterMainOpportunity());
        }
    }

    public function test_product_create_validates_and_logs(): void
    {
        $this->post('/products', ['product_name' => '', 'product_status' => 'unknown'])->assertSessionHasErrors(['product_name', 'product_status']);
        $this->post('/products', [
            'product_name' => 'Manual mock item', 'product_status' => 'discovered', 'has_extra_comm' => '1', 'opportunity_score' => 81,
        ])->assertRedirect();
        $product = Product::where('product_name', 'Manual mock item')->firstOrFail();
        $this->assertTrue($product->has_extra_comm);
        $this->assertSame('hot', $product->score_status);
        $this->assertTrue($product->activityLogs()->where('event', 'product.created')->exists());
    }

    public function test_product_update_records_status_change(): void
    {
        $product = Product::firstOrFail();
        $this->put("/products/{$product->id}", [
            'product_name' => $product->product_name,
            'product_status' => 'watching',
            'has_extra_comm' => '1',
        ])->assertRedirect();

        $this->assertSame(ProductStatus::Watching, $product->fresh()->product_status);
        $this->assertTrue($product->activityLogs()->where('event', 'product.status_changed')->exists());
    }

    public function test_market_watch_defaults_to_extra_comm_only_and_can_show_all(): void
    {
        $marketWatch = $this->get('/market-watch')->assertOk();
        $this->assertSame(14, $marketWatch->viewData('products')->total());
        $this->assertSame(14, Product::mainOpportunity()->count());
        $this->assertSame(18, Product::where('has_extra_comm', true)->count());
        $this->assertSame(24, $this->get('/market-watch?extra_comm=0')->assertOk()->viewData('products')->total());
        $this->assertSame(24, $this->get('/products')->assertOk()->viewData('products')->total());
        $this->assertSame(0, Product::mainOpportunity()->whereIn('product_status', ['rejected', 'archived'])->count());
    }

    public function test_affiliate_and_image_filters_work_together(): void
    {
        $response = $this->get('/market-watch?extra_comm=0&affiliate=1&images=1');
        $response->assertOk();
        $this->assertSame(Product::whereNotNull('affiliate_url')->has('images')->count(), $response->viewData('products')->total());
    }

    public function test_category_status_and_score_filters_work(): void
    {
        $response = $this->get('/products?category=Home&status=discovered&min_score=80');
        $response->assertOk();
        foreach ($response->viewData('products') as $product) {
            $this->assertSame('Home', $product->category);
            $this->assertSame(ProductStatus::Discovered, $product->product_status);
            $this->assertGreaterThanOrEqual(80, $product->opportunity_score);
        }
    }

    public function test_product_detail_shows_links_images_and_matrix(): void
    {
        $product = Product::first();
        $this->get("/products/{$product->id}")->assertOk()->assertSee($product->product_name)->assertSee('EXTRA COMM')->assertSee('Content matrix')->assertSee('Download all images');
    }

    public function test_copy_endpoint_requires_link_and_logs_action(): void
    {
        $withLink = Product::whereNotNull('affiliate_url')->firstOrFail();
        $withoutLink = Product::whereNull('affiliate_url')->firstOrFail();
        $this->post("/products/{$withLink->id}/affiliate-copy")->assertOk()->assertJson(['ok' => true]);
        $this->post("/products/{$withoutLink->id}/affiliate-copy")->assertStatus(422);
        $this->assertSame(1, ActivityLog::where('event', 'product.affiliate_link_copied')->count());
    }

    public function test_local_image_download_and_missing_image_handling(): void
    {
        $product = Product::has('images')->firstOrFail();
        $image = $product->images()->firstOrFail();
        $this->get("/products/{$product->id}/images/{$image->id}/download")->assertOk()->assertDownload();
        $this->get("/products/{$product->id}/images/download-all")->assertOk()->assertDownload();
        $empty = Product::doesntHave('images')->firstOrFail();
        $this->get("/products/{$empty->id}")->assertOk()->assertSee('No product image available');
        $this->get("/products/{$empty->id}/images/download-all")->assertNotFound();
    }

    public function test_product_content_page_and_snapshot_relationships(): void
    {
        $product = Product::has('snapshots')->has('contents')->firstOrFail();
        $this->assertGreaterThan(0, $product->images()->count());
        $this->assertGreaterThan(1, $product->snapshots()->count());
        $this->assertInstanceOf(Page::class, $product->contents()->first()->page);
        $this->assertInstanceOf(Product::class, Page::has('contents')->first()->contents()->first()->product);
    }

    public function test_pre_test_content_cannot_claim_personal_use_or_real_review(): void
    {
        $product = Product::where('product_status', ProductStatus::PreTest)->mainOpportunity()->firstOrFail();
        $imagePage = Page::where('content_style', 'image_post')->firstOrFail();
        $this->post('/contents', ['product_id' => $product->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post', 'caption' => 'I tried this product'])->assertSessionHasErrors('caption');
        $this->post('/contents', ['product_id' => $product->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post', 'caption' => 'I have tried this product'])->assertSessionHasErrors('caption');
        $this->post('/contents', ['product_id' => $product->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post', 'image_prompt' => "I've tested this product"])->assertSessionHasErrors('image_prompt');
        $testing = Product::where('product_status', ProductStatus::Testing)->mainOpportunity()->firstOrFail();
        $this->post('/contents', ['product_id' => $testing->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post', 'caption' => 'I have tried this product'])->assertSessionHasErrors('caption');
        $realPage = Page::where('content_style', 'real_review')->firstOrFail();
        $this->post('/contents', ['product_id' => $product->id, 'page_id' => $realPage->id, 'content_type' => 'real_review'])->assertSessionHasErrors('content_type');
        $this->post('/contents', ['product_id' => $product->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post', 'caption' => 'Product features to check before buying.'])->assertRedirect();
        $this->assertSame('non_personal', Content::latest('id')->first()->experience_basis);
    }

    public function test_page_strategy_and_extra_comm_eligibility_are_enforced(): void
    {
        $product = Product::mainOpportunity()->firstOrFail();
        $imagePage = Page::where('content_style', 'image_post')->firstOrFail();
        $this->post('/contents', ['product_id' => $product->id, 'page_id' => $imagePage->id, 'content_type' => 'ai_video'])->assertSessionHasErrors('page_id');
        $ineligible = Product::where('has_extra_comm', false)->firstOrFail();
        $this->post('/contents', ['product_id' => $ineligible->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post'])->assertSessionHasErrors('product_id');
        foreach ([ProductStatus::Rejected, ProductStatus::Archived] as $excludedStatus) {
            $excluded = Product::where('has_extra_comm', true)->where('product_status', $excludedStatus)->firstOrFail();
            $this->post('/contents', ['product_id' => $excluded->id, 'page_id' => $imagePage->id, 'content_type' => 'image_post'])->assertSessionHasErrors('product_id');
        }
        $this->get('/pages')->assertOk()->assertSee('Page 5');
    }

    public function test_received_product_can_have_real_review_draft(): void
    {
        $product = Product::where('product_status', ProductStatus::Received)->mainOpportunity()->firstOrFail();
        $page = Page::where('content_style', 'real_review')->firstOrFail();
        $this->post('/contents', [
            'product_id' => $product->id,
            'page_id' => $page->id,
            'content_type' => 'real_review',
            'hook' => 'Draft real demonstration',
        ])->assertRedirect();

        $this->assertSame('real_use', Content::latest('id')->first()->experience_basis);
        $imagePage = Page::where('content_style', 'image_post')->firstOrFail();
        $this->post('/contents', [
            'product_id' => $product->id,
            'page_id' => $imagePage->id,
            'content_type' => 'image_post',
            'caption' => 'I have tried this product',
        ])->assertRedirect();
        $this->assertSame('real_use', Content::latest('id')->first()->experience_basis);
    }
}
