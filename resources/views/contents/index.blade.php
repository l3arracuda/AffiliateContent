@extends('layouts.app')
@section('title', 'Content')
@section('content')
<div class="page-heading"><div><div class="eyebrow">CONTENT FACTORY</div><h1>Content</h1><p>Drafts linked to products and pages. Phase 0 does not generate or publish content automatically.</p></div><a class="button primary" href="{{ route('contents.create') }}">+ Create draft</a></div>
<section class="panel"><div class="table-scroll"><table><thead><tr><th>Product</th><th>Page</th><th>Type</th><th>Angle</th><th>Experience basis</th><th>Status</th></tr></thead><tbody>@forelse($contents as $content)<tr><td><a href="{{ route('products.show', $content->product) }}">{{ $content->product->product_name }}</a></td><td>{{ $content->page->name }}</td><td>{{ str_replace('_', ' ', $content->content_type) }}</td><td>{{ $content->content_angle ?? '—' }}</td><td><span class="badge {{ $content->experience_basis === 'real_use' ? 'good' : '' }}">{{ str_replace('_', ' ', $content->experience_basis) }}</span></td><td>{{ $content->status }}</td></tr>@empty<tr><td colspan="6" class="empty">No content drafts yet.</td></tr>@endforelse</tbody></table></div><div class="pagination">{{ $contents->links() }}</div></section>
@endsection
