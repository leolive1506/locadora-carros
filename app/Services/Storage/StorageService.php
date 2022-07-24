<?php
namespace App\Services\Storage;

use Exception;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public static function delete($path, $disk = 'public')
    {
        try {
            Storage::disk('public')->delete($path);
        } catch (Exception $e) {
            return response()->json(['message' => 'error delete file', 'exception' => $e]);
        }
    }
}
