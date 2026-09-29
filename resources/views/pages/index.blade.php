@extends('layouts.app')
@section('title', 'Pages')
@section('content')
<div class="page-heading"><div><div class="eyebrow">FIVE PAGE STRATEGY</div><h1>Pages</h1><p>Four pre-test channels and one real product channel, all seeded as mock pages.</p></div></div>
<div class="page-card-grid">@forelse($pages as $page)<section class="panel page-card"><div class="eyebrow">{{ $page->platform }} CHANNEL</div><h2>{{ $page->name }}</h2><p>{{ $page->description }}</p><div><span class="badge {{ $page->active ? 'good' : 'dim' }}">{{ $page->active ? 'Active' : 'Inactive' }}</span><span class="muted">{{ $page->contents_count }} drafts · {{ str_replace('_', ' ', $page->content_style) }}</span></div></section>@empty<div class="panel empty">No pages yet. Run the seeder.</div>@endforelse</div>
@endsection
