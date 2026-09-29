@extends('layouts.app')
@section('title', 'Create content draft')
@section('content')
<div class="back-link"><a href="{{ route('contents.index') }}">← Content</a></div><div class="page-heading"><div><div class="eyebrow">CONTENT STUDIO · PHASE 0</div><h1>Create content draft</h1><p>Use product information only until an item has been received and actually tested.</p></div></div>
<form class="panel form-panel" method="post" action="{{ route('contents.store') }}">@csrf
<div class="notice">Personal-use claims and real reviews require product status received, real_review, or scaling. Drafts are never posted automatically.</div>
<div class="form-grid"><label>Product <span class="required">*</span><select name="product_id" required><option value="">Choose product</option>@foreach($products as $product)<option value="{{ $product->id }}" @selected((int)old('product_id', $selectedProduct) === $product->id)>{{ $product->product_name }} ({{ $product->product_status->value }})</option>@endforeach</select></label>
<label>Page <span class="required">*</span><select name="page_id" required><option value="">Choose page</option>@foreach($pages as $page)<option value="{{ $page->id }}" @selected((int)old('page_id') === $page->id)>{{ $page->name }}</option>@endforeach</select></label>
<label>Content type <span class="required">*</span><select name="content_type" required><option value="image_post" @selected(old('content_type') === 'image_post')>Image post</option><option value="ai_video" @selected(old('content_type') === 'ai_video')>AI video concept</option><option value="real_review" @selected(old('content_type') === 'real_review')>Real review</option></select></label>
<label>Content angle<input name="content_angle" value="{{ old('content_angle') }}" maxlength="255" placeholder="Problem / Solution"></label></div>
<label>Hook<textarea name="hook" rows="2">{{ old('hook') }}</textarea></label><label>Caption<textarea name="caption" rows="4">{{ old('caption') }}</textarea></label><label>Script<textarea name="script" rows="4">{{ old('script') }}</textarea></label><label>Image prompt<textarea name="image_prompt" rows="3">{{ old('image_prompt') }}</textarea></label><label>Video prompt<textarea name="video_prompt" rows="3">{{ old('video_prompt') }}</textarea></label>
<div class="actions"><button class="button primary" type="submit">Save draft</button></div></form>
@endsection
