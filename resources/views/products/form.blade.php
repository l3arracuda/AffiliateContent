@extends('layouts.app')
@section('title', $product->exists ? 'Edit product' : 'Add product')
@section('content')
<div class="back-link"><a href="{{ $product->exists ? route('products.show', $product) : route('products.index') }}">← Back to products</a></div>
<div class="page-heading"><div><div class="eyebrow">PRODUCT DATA</div><h1>{{ $product->exists ? 'Edit product' : 'Add product' }}</h1><p>Enter mock or manually verified product details. Missing values may be left blank.</p></div></div>
<form class="panel form-panel" method="post" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">@csrf @if($product->exists) @method('PUT') @endif
<div class="form-grid">
<label>Product name <span class="required">*</span><input name="product_name" value="{{ old('product_name', $product->product_name) }}" required maxlength="255"></label>
<label>External ID<input name="external_product_id" value="{{ old('external_product_id', $product->external_product_id) }}" maxlength="255"></label>
<label>Category<input name="category" value="{{ old('category', $product->category) }}"></label>
<label>Shop<input name="shop_name" value="{{ old('shop_name', $product->shop_name) }}"></label>
<label>Product URL<input type="url" name="product_url" value="{{ old('product_url', $product->product_url) }}"></label>
<label>Affiliate URL<input type="url" name="affiliate_url" value="{{ old('affiliate_url', $product->affiliate_url) }}"></label>
<label>Price (฿)<input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}"></label>
<label>Sale price (฿)<input type="number" step="0.01" min="0" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"></label>
<label>Rating<input type="number" step="0.01" min="0" max="5" name="rating" value="{{ old('rating', $product->rating) }}"></label>
<label>Review count<input type="number" min="0" name="review_count" value="{{ old('review_count', $product->review_count) }}"></label>
<label>Sold count<input type="number" min="0" name="sold_count" value="{{ old('sold_count', $product->sold_count) }}"></label>
<label>Base commission (%)<input type="number" step="0.01" min="0" name="base_commission" value="{{ old('base_commission', $product->base_commission) }}"></label>
<label>Extra commission (%)<input type="number" step="0.01" min="0" name="extra_commission" value="{{ old('extra_commission', $product->extra_commission) }}"></label>
<label>Opportunity score<input type="number" min="0" max="100" name="opportunity_score" value="{{ old('opportunity_score', $product->opportunity_score) }}"></label>
<label>Status <span class="required">*</span><select name="product_status" required>@foreach($statuses as $status)<option value="{{ $status }}" @selected(old('product_status', $product->product_status?->value ?? 'discovered') === $status)>{{ str_replace('_', ' ', $status) }}</option>@endforeach</select></label>
<label class="checkbox-field"><input type="checkbox" name="has_extra_comm" value="1" @checked(old('has_extra_comm', $product->has_extra_comm))><span>Has EXTRA COMM<br><small>Required for the main opportunity list.</small></span></label>
</div><label>Notes<textarea name="notes" rows="4">{{ old('notes', $product->notes) }}</textarea></label><div class="actions"><button class="button primary" type="submit">{{ $product->exists ? 'Save changes' : 'Create product' }}</button></div></form>
@endsection
