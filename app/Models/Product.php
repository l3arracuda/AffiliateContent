<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'has_extra_comm' => 'boolean',
            'product_status' => ProductStatus::class,
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'rating' => 'decimal:2',
            'base_commission' => 'decimal:2',
            'extra_commission' => 'decimal:2',
            'last_checked_at' => 'datetime',
            'extra_comm_checked_at' => 'datetime',
            'affiliate_link_checked_at' => 'datetime',
            'images_checked_at' => 'datetime',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(ProductSnapshot::class)->orderByDesc('snapshot_date');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    public function scopeMainOpportunity(Builder $query): Builder
    {
        return $query->where('has_extra_comm', true)
            ->whereNotIn('product_status', [ProductStatus::Rejected->value, ProductStatus::Archived->value]);
    }

    public function getMainImageAttribute(): ?ProductImage
    {
        return $this->images->firstWhere('image_type', 'main') ?? $this->images->first();
    }

    public function getIsReadyAttribute(): bool
    {
        return $this->has_extra_comm
            && $this->product_status->canEnterMainOpportunity()
            && filled($this->affiliate_url)
            && $this->images_count > 0;
    }
}
