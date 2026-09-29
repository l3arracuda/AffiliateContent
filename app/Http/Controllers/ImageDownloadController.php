<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ImageDownloadController extends Controller
{
    public function one(Product $product, ProductImage $image): BinaryFileResponse
    {
        abort_unless($image->product_id === $product->id, 404);
        $path = $this->safePath($image);
        abort_unless($path, 404);
        $product->activityLogs()->create(['event' => 'product.image_downloaded', 'details' => ['image_id' => $image->id]]);

        return response()->download($path, "product-{$product->id}-image-{$image->id}.svg");
    }

    public function all(Product $product): BinaryFileResponse
    {
        $paths = $product->images->map(fn ($image) => [$image, $this->safePath($image)])->filter(fn ($pair) => $pair[1]);
        abort_if($paths->isEmpty(), 404);
        $file = tempnam(sys_get_temp_dir(), 'affiliate-images-');
        $zip = new ZipArchive;
        if ($zip->open($file, ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not prepare image archive.');
        }
        foreach ($paths as [$image, $path]) {
            $zip->addFile($path, "product-{$product->id}-image-{$image->id}.svg");
        }
        $zip->close();
        $product->activityLogs()->create(['event' => 'product.images_downloaded', 'details' => ['count' => $paths->count()]]);

        return response()->download($file, "product-{$product->id}-images.zip")->deleteFileAfterSend(true);
    }

    private function safePath(ProductImage $image): ?string
    {
        if (! $image->local_path) {
            return null;
        }
        $base = realpath(public_path('mock-products'));
        $path = realpath(public_path($image->local_path));

        return $base && $path && str_starts_with($path, $base.DIRECTORY_SEPARATOR) && is_file($path) ? $path : null;
    }
}
