<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Upload an image file.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,gif,webp,svg|max:5120',
            'folder' => 'nullable|string|alpha_dash|max:50',
        ]);

        $folder = $request->input('folder', 'uploads');
        $allowedFolders = ['uploads', 'projects', 'profile', 'certifications', 'templates'];

        if (!in_array($folder, $allowedFolders)) {
            $folder = 'uploads';
        }

        $path = $request->file('file')->store($folder, 'public');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    /**
     * Delete an uploaded file.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string|max:255',
        ]);

        $path = $request->input('path');

        // Security: ensure path doesn't traverse directories
        if (str_contains($path, '..') || str_starts_with($path, '/')) {
            return response()->json(['error' => 'Invalid file path.'], 422);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'File deleted successfully.']);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
