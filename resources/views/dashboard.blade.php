@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-heading"><div><div class="eyebrow">OVERVIEW</div><h1>Dashboard</h1><p>Choose what to work on today from fictional Phase 0 products.</p></div><a class="button primary" href="{{ route('market-watch.index') }}">Explore Market Watch →</a></div>
<div class="stat-grid">@foreach($stats as $label => $value)<div class="stat-card"><span>{{ $label }}</span><strong>{{ $value }}</strong></div>@endforeach</div>
<section class="panel"><div class="section-heading"><div><h2>Top opportunities</h2><p>EXTRA COMM products ranked by mock score.</p></div><a href="{{ route('market-watch.index') }}">View all →</a></div>
<div class="table-scroll"><table><thead><tr><th>Product</th><th>Category</th><th>Score</th><th>Status</th><th>Ready</th></tr></thead><tbody>
@forelse($products as $product)<tr><td><a class="product-cell" href="{{ route('products.show', $product) }}">@if($product->main_image)<img src="{{ asset($product->main_image->local_path) }}" alt="">@else<span class="no-image">No image</span>@endif <strong>{{ $product->product_name }}</strong></a></td><td>{{ $product->category ?? '—' }}</td><td><span class="score {{ $product->score_status }}">{{ $product->opportunity_score ?? '—' }}</span></td><td><span class="badge">{{ str_replace('_', ' ', $product->product_status->value) }}</span></td><td>{{ $product->is_ready ? 'Yes' : 'Needs data' }}</td></tr>
@empty<tr><td colspan="5" class="empty">No products yet. Run the seeder or add a product.</td></tr>@endforelse
</tbody></table></div></section>
@endsection
