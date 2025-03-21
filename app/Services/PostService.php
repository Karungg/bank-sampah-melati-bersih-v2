<?php

namespace App\Services;

use App\Contracts\PostServiceInterface;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostService implements PostServiceInterface
{
    public function updateImage(Post $post): void
    {
        try {
            if ($post->isDirty('images')) {

                $originalFieldContents = $post->getOriginal('images');
                $newFieldContents = $post->images;

                # We attempt to JSON decode the field. If it is an array, this is an indication we have ->multiple() activated
                if (is_array($originalFieldContents)) {
                    $originalFieldContentsDecoded = $originalFieldContents;
                } else {
                    $originalFieldContentsDecoded = json_decode($originalFieldContents);
                }

                # Clean up empty entries in the resulting array
                if (is_array($originalFieldContentsDecoded)) $originalFieldContentsDecoded = array_filter($originalFieldContentsDecoded);

                # Simple case: one file
                if (!is_array($originalFieldContentsDecoded) or count($originalFieldContentsDecoded) == 0) {
                    Storage::disk('public')->delete($originalFieldContents);
                }

                # Complex case: multiple files
                else {
                    foreach ($originalFieldContentsDecoded as $originalFile) {
                        if (trim($originalFile) != null && !in_array($originalFile, $newFieldContents)) {
                            Storage::disk('public')->delete($originalFile);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::error("Failed to update image in post resource", [
                "post_id" => $post->id,
                "message" => $e->getMessage(),
            ]);
            throw new Exception("Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.");
        }
    }

    public function deleted(Post $post): void
    {
        try {
            if (! is_null($post->images)) {

                # We attempt to JSON decode the field. If it is an array, there are multiple files
                $fieldContentsDecoded = json_decode($post->images);

                # Simple case: one file
                if (!is_array($fieldContentsDecoded)) {
                    Storage::disk('public')->delete($post->images);
                }

                # Complex case: multiple files
                else {

                    foreach ($fieldContentsDecoded as $file) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
        } catch (Exception $e) {
            Log::error("Failed to delete image in post resource", [
                "post_id" => $post->id,
                "message" => $e->getMessage(),
            ]);
            throw new Exception("Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.");
        }
    }
}
