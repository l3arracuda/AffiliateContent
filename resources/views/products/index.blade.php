@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="page-heading"><div><div class="eyebrow">PRODUCT DISCOVERY</div><h1>{{ $title }}</h1><p>{{ $title === 'Market Watch' ? 'EXTRA COMM is on by default for the main opportunity list.' : 'Review all products, including those outside the main opportunity list.' }}</p></div><a class="button primary" href="{{ route('products.create') }}">+ Add product</a></div>
<form class="panel filter-panel" method="get">
    <label>EXTRA COMM<select name="extra_comm"><option value="1" @selected($extraOnly)>Only eligible</option><option value="0" @selected(!$extraOnly)>All products</option></select></label>
    <label>Affiliate link<select name="affiliate"><option value="0">Any</option><option value="1" @selected(($filters['affiliate'] ?? '0') === '1')>Has link</option></select></label>
    <label>Images<select name="images"><option value="0">Any</option><option value="1" @selected(($filters['images'] ?? '0') === '1')>Has images</option></select></label>
    <label>Category<select name="category"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>@endforeach</select></label>
    <label>Status<select name="status"><option value="">All statuses</option>@foreach(\App\Enums\ProductStatus::values() as $status)<option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ str_replace('_', ' ', $status) }}</option>@endforeach</select></label>
    <label>Minimum score<input type="number" name="min_score" min="0" max="100" value="{{ $filters['min_score'] ?? '' }}" placeholder="0–100"></label>
    <button class="button primary" type="submit">Apply filters</button>
</form>
<section class="panel"><div class="section-heading"><div><h2>Products <span class="muted">({{ $products->total() }})</span></h2><p>All values on this screen are sample data.</p></div></div>
<div class="table-scroll"><table><thead><tr><th>Product</th><th>Price</th><th>EXTRA COMM</th><th>Affiliate</th><th>Images</th><th>Score</th><th>Status</th></tr></thead><tbody>
@forelse($products as $product)<tr><td><a class="product-cell" href="{{ route('products.show', $product) }}">@if($product->main_image)<img src="{{ asset($product->main_image->local_path) }}" alt="">@else<span class="no-image">No image</span>@endif<span><strong>{{ $product->product_name }}</strong><small>{{ $product->category ?? 'Uncategorized' }} · {{ $product->shop_name ?? 'Unknown shop' }}</small></span></a></td><td>{{ $product->sale_price === null ? '—' : '฿'.number_format((float)$product->sale_price, 2) }}</td><td><span class="badge {{ $product->has_extra_comm ? 'good' : 'dim' }}">{{ $product->has_extra_comm ? 'Eligible' : 'No' }}</span></td><td>{{ filled($product->affiliate_url) ? '✓' : '—' }}</td><td>{{ $product->images_count }}</td><td><span class="score {{ $product->score_status }}">{{ $product->opportunity_score ?? '—' }}</span></td><td><span class="badge">{{ str_replace('_', ' ', $product->product_status->value) }}</span></td></tr>
@empty<tr><td colspan="7" class="empty">No products match these filters. Try clearing a filter.</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $products->links() }}</div></section>
@endsection
