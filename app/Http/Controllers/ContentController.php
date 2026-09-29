<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('contents.index', ['contents' => Content::with(['product', 'page'])->latest()->paginate(15)]);
    }

    public function create(Request $request): View
    {
        return view('contents.create', [
            'products' => Product::mainOpportunity()->orderBy('product_name')->get(),
            'pages' => Page::where('active', true)->get(),
            'selectedProduct' => $request->integer('product_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'page_id' => ['required', 'exists:pages,id'],
            'content_type' => ['required', Rule::in(['image_post', 'ai_video', 'real_review'])],
            'content_angle' => ['nullable', 'string', 'max:255'],
            'hook' => ['nullable', 'string', 'max:3000'],
            'caption' => ['nullable', 'string', 'max:10000'],
            'script' => ['nullable', 'string', 'max:10000'],
            'image_prompt' => ['nullable', 'string', 'max:10000'],
            'video_prompt' => ['nullable', 'string', 'max:10000'],
        ]);
        $product = Product::findOrFail($data['product_id']);
        if (! $product->has_extra_comm) {
            throw ValidationException::withMessages(['product_id' => 'Main content workflow requires EXTRA COMM.']);
        }
        $page = Page::findOrFail($data['page_id']);
        if ($page->content_style !== $data['content_type']) {
            throw ValidationException::withMessages(['page_id' => 'Content type must match the selected page strategy.']);
        }
        $realExperience = $product->product_status->permitsRealExperience();
        if ($data['content_type'] === 'real_review' && ! $realExperience) {
            throw ValidationException::withMessages(['content_type' => 'Real review requires a received, real_review, or scaling product.']);
        }
        $copy = implode(' ', array_filter([$data['hook'] ?? null, $data['caption'] ?? null, $data['script'] ?? null]));
        if (! $realExperience && preg_match('/\b(i tried|i use|from my experience|i have used)\b|(?:ฉัน|ผม|ดิฉัน|เรา).{0,20}(?:ลองใช้|ใช้แล้ว|ใช้จริง)/iu', $copy)) {
            throw ValidationException::withMessages(['caption' => 'Personal-use claims require a received, real_review, or scaling product.']);
        }
        $data['experience_basis'] = $data['content_type'] === 'real_review' ? 'real_use' : 'non_personal';
        $data['status'] = 'draft';
        Content::create($data);

        return redirect()->route('products.show', $product)->with('success', 'Content draft created.');
    }
}
