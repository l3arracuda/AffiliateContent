<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('external_product_id')->nullable()->unique();
            $table->string('product_name');
            $table->string('category')->nullable()->index();
            $table->string('shop_name')->nullable();
            $table->text('product_url')->nullable();
            $table->text('affiliate_url')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedInteger('review_count')->nullable();
            $table->unsignedInteger('sold_count')->nullable();
            $table->decimal('base_commission', 8, 2)->nullable();
            $table->decimal('extra_commission', 8, 2)->nullable();
            $table->boolean('has_extra_comm')->default(false)->index();
            $table->string('product_status')->default('discovered')->index();
            $table->unsignedTinyInteger('opportunity_score')->nullable()->index();
            $table->string('score_status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('extra_comm_checked_at')->nullable();
            $table->timestamp('affiliate_link_checked_at')->nullable();
            $table->timestamp('images_checked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->text('image_url')->nullable();
            $table->string('local_path')->nullable();
            $table->string('image_type')->default('gallery');
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('download_status')->default('mock');
            $table->timestamps();
        });

        Schema::create('product_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->date('snapshot_date');
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedInteger('review_count')->nullable();
            $table->unsignedInteger('sold_count')->nullable();
            $table->decimal('base_commission', 8, 2)->nullable();
            $table->decimal('extra_commission', 8, 2)->nullable();
            $table->boolean('has_extra_comm')->default(false);
            $table->timestamp('created_at')->nullable();
            $table->unique(['product_id', 'snapshot_date']);
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('platform')->default('mock');
            $table->string('content_style');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('content_type');
            $table->string('content_angle')->nullable();
            $table->text('hook')->nullable();
            $table->text('caption')->nullable();
            $table->text('script')->nullable();
            $table->text('image_prompt')->nullable();
            $table->text('video_prompt')->nullable();
            $table->string('experience_basis')->default('non_personal');
            $table->string('status')->default('draft');
            $table->text('published_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event');
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('product_snapshots');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
